const assert = require('node:assert/strict');
const { readFileSync } = require('node:fs');
const path = require('node:path');
const { setImmediate } = require('node:timers/promises');
const { test } = require('node:test');
const vm = require('node:vm');
const ts = require('typescript');

function loadCommentScript(filename, globals) {
    const file = path.resolve(__dirname, '../../resources/assets/js', filename);
    const source = ts.transpileModule(readFileSync(file, 'utf8'), {
        compilerOptions: { module: ts.ModuleKind.CommonJS, target: ts.ScriptTarget.ES2022 },
        fileName: file,
    }).outputText;
    const exports = {};
    vm.runInNewContext(source, { exports, FormData, Headers, URLSearchParams, ...globals }, { filename: file });

    return exports;
}

test('the comment client sends the post, parent, text and CSRF token', async () => {
    const result = { message: 'Sent for moderation' };
    const { CommentService } = loadCommentScript('comment.service.ts', {
        async fetch(url, request) {
            assert.equal(url, '/comment/store');
            assert.equal(request.method, 'POST');
            assert.equal(request.headers['X-CSRF-TOKEN'], 'test-token');
            assert.deepEqual(Object.fromEntries(request.body), {
                post: '10', parent: '25', level: '1', message: 'A reply',
            });
            return { ok: true, json: async () => result };
        },
    });
    const service = new CommentService({ getCsrfToken: () => 'test-token' });

    assert.equal(await service.submitComment({ post: 10, parent: 25, level: 1, message: 'A reply' }), result);
});

test('the comment client rejects a failed submission', async () => {
    const { CommentService } = loadCommentScript('comment.service.ts', {
        fetch: async () => ({ ok: false, status: 422 }),
    });
    const service = new CommentService({ getCsrfToken: () => 'test-token' });

    await assert.rejects(service.submitComment({ post: 10, message: '' }), /Failed to submit comment/);
});

test('the moderation button changes its icon after publication and unpublication', async () => {
    const { button, click, requests } = moderationHarness([
        { ok: true, status: 200 },
        { ok: true, status: 200 },
    ]);

    await click(button);
    assert.match(button.innerHTML, /class="comment-publish-svg"/);
    await click(button);
    assert.match(button.innerHTML, /class="comment-unpublish-svg"/);
    assert.deepEqual(requests, Array.from({ length: 2 }, () => ({
        url: '/admin/comments/publish', method: 'PUT', id: '25', token: 'test-token',
    })));
});

test('a failed moderation request preserves the displayed status', async () => {
    const { button, click, errors, requests } = moderationHarness([{ ok: false, status: 403 }]);
    const original = button.innerHTML;

    await click(null);
    assert.equal(requests.length, 0);
    await click(button);
    assert.equal(button.innerHTML, original);
    assert.match(errors[0], /403/);
});

function moderationHarness(responses) {
    const listeners = new Map();
    const requests = [];
    const errors = [];
    const button = {
        dataset: { id: '25' },
        innerHTML: '<svg class="comment-unpublish-svg"></svg>',
        querySelector(selector) {
            return this.innerHTML.includes(`class="${selector.slice(1)}"`) ? {} : null;
        },
    };
    loadCommentScript('publish-comment.ts', {
        document: {
            addEventListener: (event, listener) => listeners.set(event, listener),
            querySelector: () => ({ getAttribute: () => 'test-token' }),
        },
        console: { error: (_message, error) => errors.push(error.message) },
        async fetch(url, { method, body, headers }) {
            requests.push({ url, method, id: body.get('id'), token: headers.get('X-CSRF-TOKEN') });
            return responses.shift();
        },
    });
    listeners.get('DOMContentLoaded')();

    return {
        button,
        requests,
        errors,
        async click(targetButton) {
            listeners.get('click')({ target: { closest: () => targetButton } });
            await setImmediate();
        },
    };
}
