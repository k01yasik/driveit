const assert = require('node:assert/strict');
const { readFileSync } = require('node:fs');
const path = require('node:path');
const { setImmediate } = require('node:timers/promises');
const { test } = require('node:test');
const vm = require('node:vm');
const ts = require('typescript');

function loadScript(name, globals) {
    const filename = path.resolve(__dirname, '../../resources/assets/js', name);
    const { outputText } = ts.transpileModule(readFileSync(filename, 'utf8'), {
        compilerOptions: { target: ts.ScriptTarget.ES2022, module: ts.ModuleKind.CommonJS },
    });
    const exports = {};
    vm.runInNewContext(outputText, { exports, FormData, console, ...globals }, { filename });
    return exports;
}

test('scroll-to-top is optional, updates after one frame and respects reduced motion', () => {
    let ready;
    loadScript('back-to-top.ts', {
        document: { addEventListener(_, handler) { ready = handler; }, querySelector: () => null },
    });
    assert.doesNotThrow(() => ready());

    const events = new Map();
    const frames = [];
    const visibility = [];
    const moves = [];
    const button = {
        addEventListener(_, handler) { events.set('click', handler); },
        classList: { toggle(name, visible) { assert.equal(name, 'back-to-top--visible'); visibility.push(visible); } },
    };
    const window = {
        scrollY: 0,
        addEventListener(event, handler) { events.set(event, handler); },
        matchMedia: () => ({ matches: true }),
        scrollTo(options) { moves.push([options.top, options.behavior]); },
    };
    loadScript('back-to-top.ts', {
        document: { querySelector: () => button, addEventListener(_, handler) { ready = handler; } },
        window, requestAnimationFrame(callback) { frames.push(callback); },
    });
    ready();
    window.scrollY = 501;
    events.get('scroll')();
    events.get('scroll')();
    assert.equal(frames.length, 1);
    frames[0]();
    assert.deepEqual(visibility, [false, true]);
    events.get('click')();
    assert.deepEqual(moves, [[0, 'auto']]);
});

test('favorites handle clicks on nested icons and render the numeric JSON count', async () => {
    let click;
    const counter = { textContent: '2' };
    const footer = { querySelector: () => counter };
    const button = { dataset: { id: '13' }, closest: () => footer };
    let resolveRequest;
    let requests = 0;
    loadScript('favorite.ts', {
        document: {
            addEventListener(_, handler) { click = handler; },
            querySelector: () => ({ content: 'token' }),
        },
        fetch(url, options) {
            requests++;
            assert.equal(url, '/user/favorite/add');
            assert.equal(options.body.get('id'), '13');
            assert.equal(options.headers['X-CSRF-TOKEN'], 'token');
            return new Promise(resolve => { resolveRequest = resolve; });
        },
    });

    click({ target: { closest: () => button } });
    click({ target: { closest: () => button } });
    assert.equal(requests, 1);
    resolveRequest({ ok: true, json: async () => ({ success: true, count: 3 }) });
    await setImmediate();
    assert.equal(counter.textContent, '3');
    assert.equal(button.dataset.pending, undefined);
});

test('a reply to any comment is inserted after its subtree and resets reply state', async () => {
    const wrapper = { dataset: { post: '19', parent: '0', level: '0' } };
    const editor = { innerHTML: '<p>Reply</p>' };
    const button = { addEventListener(_, handler) { this.submit = handler; } };
    const nextRoot = { dataset: { level: '0' }, matches: () => true };
    const child = { dataset: { level: '1' }, matches: () => true, nextElementSibling: nextRoot };
    const parent = { nextElementSibling: child };
    const reply = { dataset: { parent: '41', level: '0' }, closest: () => parent };
    let click;
    let payload;
    let inserted;
    let resolveRequest;
    const modules = {
        './dom.service': { DOMService: class { getElement(key) { return { wrapper, textEditor: editor, commentButton: button }[key]; } } },
        './comment.service': { CommentService: class { submitComment(data) { payload = data; return new Promise(resolve => { resolveRequest = resolve; }); } } },
        './comment.ui': { CommentUI: class {
            scrollToCommentElement() {}
            createCommentHtml() { return '<div>Reply</div>'; }
            insertComment(_, target) { inserted = target; }
            clearEditor() { editor.innerHTML = ''; }
        } },
    };
    const { CommentController } = loadScript('comment.controller.ts', {
        require: name => modules[name],
        document: { addEventListener(_, handler) { click = handler; } },
    });
    new CommentController();
    click({ target: { closest: () => reply } });
    const submission = button.submit({ preventDefault() {} });
    assert.equal(payload.post, '19');
    assert.equal(payload.parent, '41');
    assert.equal(payload.level, '1');
    editor.innerHTML = 'New text';
    resolveRequest({});
    await submission;

    assert.equal(inserted, child);
    assert.deepEqual(wrapper.dataset, { post: '19', parent: '0', level: '0' });
    assert.equal(editor.innerHTML, 'New text');
});

test('opening an album photo uses the full-size URL and closing removes the dialog', () => {
    const node = tag => ({
        tag, listeners: {},
        setAttribute() {},
        addEventListener(event, handler) { this.listeners[event] = handler; },
        append(...children) { this.children = children; },
        showModal() { this.open = true; },
        close() { this.open = false; this.listeners.close(); },
        remove() { this.removed = true; },
    });
    let click;
    let preview;
    loadScript('fullpage-image.ts', {
        document: {
            addEventListener(_, handler) { click = handler; },
            querySelector: () => null,
            createElement: node,
            body: { append(dialog) { preview = dialog; } },
        },
    });
    click({ target: { closest: () => null } });
    assert.equal(preview, undefined);
    click({ target: { closest: () => ({ dataset: { url: '/original.jpg' }, src: '/thumbnail.jpg', alt: 'Car' }) } });
    assert.equal(preview.children[1].src, '/original.jpg');
    assert.equal(preview.open, true);
    preview.children[0].listeners.click();
    assert.equal(preview.removed, true);
});

test('an unsuccessful cover upload preserves the current image and resets the input', async () => {
    let ready;
    const preview = { src: '/existing.jpg' };
    const fileInput = { value: 'replacement', files: [new Blob(['photo'])], addEventListener(_, callback) { this.change = callback; } };
    const imageInput = { value: '/existing.jpg' };
    const requests = [];
    const responses = [{ ok: false, status: 422 }, { ok: true, json: async () => ({ url: '/new.jpg' }) }];
    loadScript('post-upload-image.ts', {
        document: {
            addEventListener(_, handler) { ready = handler; },
            querySelector(selector) {
                return {
                    '#post_upload_image_input': fileInput, '#image': imageInput,
                    '.post_upload_image_button': { addEventListener() {} },
                    '.uploaded-image': preview, 'meta[name="csrf-token"]': { content: 'token' },
                }[selector] ?? null;
            },
        },
        localStorage: { getItem() { throw new Error('edit must not read another draft'); } },
        console: { error() {} },
        async fetch(url, options) { requests.push([url, options.method]); return responses.shift(); },
    });
    ready();
    await fileInput.change();
    assert.equal(preview.src, '/existing.jpg');
    assert.equal(imageInput.value, '/existing.jpg');
    assert.equal(fileInput.value, '');
    assert.equal(fileInput.disabled, false);
    await fileInput.change();
    assert.equal(preview.src, '/new.jpg');
    assert.equal(imageInput.value, '/new.jpg');
    assert.deepEqual(requests, [['/admin/posts/image-upload', 'POST'], ['/admin/posts/image-upload', 'POST']]);
});

test('dashboard charts initialize even when post statistics are missing', () => {
    let ready;
    const charts = [];
    const canvas = {};
    loadScript('post-chart.ts', {
        require: () => ({ Chart: class { constructor(target, config) { charts.push([target, config]); } } }),
        document: {
            getElementById: id => id === 'commentsChart' ? canvas : null,
            addEventListener(_, callback) { ready = callback; },
        },
        window: { dashboardData: { commentsVerified: 0, commentsNotVerified: 2 } },
    });
    ready();
    assert.equal(charts.length, 1);
    assert.equal(charts[0][0], canvas);
    assert.equal(charts[0][1].type, 'doughnut');
    assert.deepEqual(Array.from(charts[0][1].data.datasets[0].data), [0, 2]);
});
