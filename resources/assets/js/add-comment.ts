import { CreateHtmlElement } from './createHtmlElement';

let wrapper = document.querySelector('.add-comment-wrapper') as HTMLElement;
let commentButton = document.querySelector('.add-comment-button');
let targetElement;
let csrf = document.querySelector('meta[name="csrf-token"]') as HTMLElement;
let csrfToken = csrf.getAttribute('content') ?? '';
let replyButton = document.querySelector('.reply-button')

let createHtmlElement = new CreateHtmlElement();

class CommentResponse {
    constructor(public level: string, 
                public url: string, 
                public avatar: string, 
                public username: string, 
                public created_at: string,
                public message: string) {}
}

commentButton?.addEventListener('click', function (event) {
    let text_editor = document.querySelector('.text-editor-body') as HTMLElement;

    /*text_editor.focus();
    document.execCommand('selectAll', false, null);
    document.execCommand('removeFormat', false, null);*/

    let post = wrapper?.dataset.post ?? '';
    let level = wrapper?.dataset.level ?? '';
    let parent = wrapper?.dataset.parent ?? '';
    let message = text_editor?.innerHTML ?? '';

    let formData = new FormData();
    formData.append('post', post);
    formData.append('level', level);
    formData.append('parent', parent);
    formData.append('message', message);

    fetch("/comment/store", {
        method: "POST",
        body: formData,
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    })
        .then((response) => { return response.json()})
        .then((result: CommentResponse) => {
        localStorage.removeItem('post-body');
        if(text_editor) text_editor.innerHTML = '<div><br /></div>';

        let commentHtml = `<div class='comment-item level-${result.level}' data-level='${result.level}'>
                                <div class='header'>
                                    <a href='${result.url}' class='user-avatar-link header-item'>
                                        <img src='${result.avatar}' class='user-avatar' alt='${result.username}' /> 
                                    </a>
                                    <a href='${result.url}' class='post-author header-item'>${result.username}</a>
                                    <div class='right'>${result.created_at}</div>
                                </div>
                                <div class='body'>
                                    <p>${result.message}</p>
                                </div>
                            </div>`;

        if (targetElement) {
            targetElement.insertAdjacentElement('afterend', <Element>createHtmlElement.fromString(commentHtml));
            targetElement = undefined;
        } else {
            let commentsWrapper = document.querySelector('.comments-wrapper') as HTMLElement;
            commentsWrapper.insertAdjacentElement('afterend', <Element>createHtmlElement.fromString(commentHtml));
        }
    });
})


replyButton?.addEventListener('click', function (event) {
    let element = event.currentTarget as HTMLElement;
    let level = parseInt(element?.dataset.level ?? '');
    level++;
    let parent = element.dataset.parent;
    let animateElement = document.querySelector('html, body') as HTMLElement;
    let addCommentElement = document.getElementById('#add-comment') as HTMLElement;

    wrapper.dataset.level = level.toString();
    wrapper.dataset.parent = parent;

    animateElement.animate({
        scrollTop: addCommentElement.offsetTop
    }, 2000);

    let clickedParent = element?.closest('.comment-item') as HTMLElement;

    let clickedParentLevel = parseInt(clickedParent?.dataset.level ?? '');

    clickedParentLevel++;

    let nextSibling = clickedParent?.nextElementSibling as HTMLElement

    let nextSiblingLevel = nextSibling.dataset.level ?? '';

    let nextSiblingLevelInt = parseInt(nextSiblingLevel);

     while (nextSiblingLevelInt >= clickedParentLevel) {
        clickedParent = clickedParent.nextElementSibling as HTMLElement;
    }

    targetElement = clickedParent;
});