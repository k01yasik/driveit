/**
 * Utility class for creating HTML elements from strings
 */
export class HtmlElementCreator {
    /**
     * Creates a DOM element from an HTML string
     * @param html HTML string to parse
     * @returns First child node of the parsed HTML or null if empty
     * @throws {Error} If the HTML string is empty or invalid
     */
    public createFromString(html: string): ChildNode | null {
        if (!html?.trim()) {
            throw new Error('HTML string cannot be empty');
        }

        const template = document.createElement('template');
        template.innerHTML = html.trim();
        
        return template.content.firstChild?.cloneNode(true) ?? null;
    }
}
