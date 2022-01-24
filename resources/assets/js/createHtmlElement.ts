export class CreateHtmlElement {
    fromString(html: string): ChildNode | null {
        let template = document.createElement('template');
        template.innerHTML = html;
        return template.content.firstChild;
    }
}