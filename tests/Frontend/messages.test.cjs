const assert = require('node:assert/strict');
const { readFileSync } = require('node:fs');
const path = require('node:path');
const { test } = require('node:test');
const { setImmediate } = require('node:timers/promises');
const vm = require('node:vm');
const ts = require('typescript');

function conversationHarness(visibilityState = 'visible') {
    const listeners = new Map();
    const handlers = new Map();
    const rendered = [];
    const reads = [];
    const counter = {
        textContent: '0',
        hidden: true,
        toggleAttribute(name, value) {
            assert.equal(name, 'hidden');
            this.hidden = value;
        },
    };
    const conversation = {
        dataset: { friend: '7', readUrl: '/user/alice/messages/bob/read' },
        querySelector(selector) {
            return rendered.some(html => html.includes(selector.slice(1, -1))) ? {} : null;
        },
        insertAdjacentHTML(position, html) {
            assert.equal(position, 'beforeend');
            rendered.push(html);
        },
    };
    const document = {
        visibilityState,
        querySelector(selector) {
            return {
                '.channel': { getAttribute: () => '3' },
                '[data-read-url]': conversation,
                '.messages-count': counter,
                'meta[name="csrf-token"]': { content: 'test-token' },
            }[selector] ?? null;
        },
        addEventListener(event, handler) {
            listeners.set(event, handler);
        },
    };
    const channel = {
        listen(event, handler) {
            handlers.set(event, handler);
            return this;
        },
    };
    const filename = path.resolve(__dirname, '../../resources/assets/js/channel.ts');
    const { outputText } = ts.transpileModule(readFileSync(filename, 'utf8'), {
        compilerOptions: { module: ts.ModuleKind.CommonJS, target: ts.ScriptTarget.ES2022 },
        fileName: filename,
    });

    vm.runInNewContext(outputText, {
        exports: {}, require, document,
        window: { Echo: { private(name) { assert.equal(name, 'user.3'); return channel; } } },
        async fetch(url, options) {
            reads.push({ url, method: options.method, token: options.headers['X-CSRF-TOKEN'], body: JSON.parse(options.body) });
            return { ok: true };
        },
    }, { filename });
    listeners.get('DOMContentLoaded')();

    return {
        counter, rendered, reads,
        receive: senderId => handlers.get('MessageSaved')({
            sender: { id: senderId, username: 'bob', profile_url: '/user/bob' },
            message: { id: 42, text: 'Hello', created_at: '2026-11-25' },
        }),
        async focus() {
            document.visibilityState = 'visible';
            listeners.get('visibilitychange')();
            await setImmediate();
        },
    };
}

test('a new message in the visible conversation is rendered and marked read only once', async () => {
    const chat = conversationHarness();
    await chat.receive(7);
    await chat.receive(7);

    assert.equal(chat.rendered.length, 1);
    assert.deepEqual(chat.reads, [{
        url: '/user/alice/messages/bob/read', method: 'PATCH', token: 'test-token', body: { id: 42 },
    }]);
    assert.equal(chat.counter.hidden, true);
});

test('messages remain unread while the tab is hidden or another conversation is open', async () => {
    const chat = conversationHarness('hidden');
    await chat.receive(7);
    await chat.receive(8);
    assert.equal(chat.rendered.length, 1);
    assert.equal(chat.reads.length, 0);
    assert.equal(chat.counter.textContent, '2');

    await chat.focus();
    assert.equal(chat.reads.length, 1);
    assert.equal(chat.counter.textContent, '1');
});
