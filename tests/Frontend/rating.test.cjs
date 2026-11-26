const assert = require('node:assert/strict');
const { readFileSync } = require('node:fs');
const path = require('node:path');
const { test } = require('node:test');
const vm = require('node:vm');
const ts = require('typescript');

function voteButton(id) {
    const count = { textContent: '2' };
    const status = { hidden: true, toggleAttribute(name, value) { this[name] = value; } };
    return {
        dataset: { id, ratingUrl: '/rating/post' },
        count, status, disabled: false, pressed: 'false',
        setAttribute(name, value) {
            assert.equal(name, 'aria-pressed');
            this.pressed = value;
        },
        querySelector(selector) { return selector === '[data-rating-count]' ? count : status; },
    };
}

function voteHarness(fetch, leaderboard = false) {
    const buttons = [voteButton('7'), voteButton('7'), voteButton('8')];
    const listeners = new Map();
    let reloads = 0;
    const document = {
        addEventListener(event, handler) { listeners.set(event, handler); },
        querySelector(selector) {
            return selector === 'meta[name="csrf-token"]' ? { content: 'csrf' } : leaderboard ? {} : null;
        },
        querySelectorAll() { return buttons; },
    };
    const filename = path.resolve(__dirname, '../../resources/assets/js/rating.ts');
    const script = ts.transpileModule(readFileSync(filename, 'utf8'), {
        compilerOptions: { target: ts.ScriptTarget.ES2022 },
    }).outputText;

    vm.runInNewContext(script, {
        document, FormData, fetch, console: { error() {} },
        window: { location: { reload() { reloads++; } } },
    }, { filename });
    listeners.get('DOMContentLoaded')();

    return {
        buttons,
        reloads: () => reloads,
        click: index => listeners.get('click')({ target: { closest: () => buttons[index] } }),
    };
}

test('vote response updates all controls for the same post while ignoring duplicate clicks', async () => {
    let send;
    let requests = 0;
    const harness = voteHarness((url, options) => {
        requests++;
        assert.equal(url, '/rating/post');
        assert.equal(options.method, 'POST');
        assert.equal(options.body.get('id'), '7');
        assert.equal(options.headers['X-CSRF-TOKEN'], 'csrf');
        return new Promise(resolve => { send = resolve; });
    });
    const click = harness.click(0);
    assert.equal(harness.buttons[0].disabled, true);
    await harness.click(1);
    assert.equal(requests, 1);

    send({ ok: true, text: async () => '3', headers: new Headers({ 'X-Rating-Voted': '1' }) });
    await click;
    for (const button of harness.buttons.slice(0, 2)) {
        assert.equal(button.status.hidden, false);
        assert.equal(button.pressed, 'true');
        assert.equal(button.count.textContent, '3');
        assert.equal(button.disabled, false);
    }
    assert.equal(harness.buttons[2].pressed, 'false');
    assert.equal(harness.reloads(), 0);
});

test('a failed vote leaves the indicator unchanged and a successful vote refreshes the leaderboard', async () => {
    const responses = [{ ok: false, status: 500 }, {
        ok: true, text: async () => '1', headers: new Headers({ 'X-Rating-Voted': '0' }),
    }];
    const harness = voteHarness(async () => responses.shift(), true);
    const button = harness.buttons[0];
    button.pressed = 'true';
    button.status.hidden = false;

    await harness.click(0);
    assert.equal(button.pressed, 'true');
    assert.equal(button.count.textContent, '2');
    assert.equal(harness.reloads(), 0);

    await harness.click(0);
    assert.equal(button.pressed, 'false');
    assert.equal(button.status.hidden, true);
    assert.equal(button.count.textContent, '1');
    assert.equal(harness.reloads(), 1);
});
