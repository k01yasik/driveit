export class FriendRequestApiService {
    public static async sendRequest(
        id: string,
        username: string,
        apiUrl: string = '/user/friends/requests'
    ): Promise<void> {
        const formData = new FormData();
        formData.append('id', id);
        formData.append('username', username);

        const csrfToken = this.getCsrfToken();

        const response = await fetch(apiUrl, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            },
            body: formData,
        });

        if (!response.ok) {
            throw new Error('Failed to process friend request');
        }
    }

    private static getCsrfToken(): string {
        const token = document.querySelector<HTMLMetaElement>('meta[name="csrf-token"]')?.content;
        if (!token) {
            throw new Error('CSRF token not found');
        }
        return token;
    }
}
