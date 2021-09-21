class Token {

    isValidToken(token) {

        const payload = this.payload(token);

        if (payload) {
            return !!(payload.iss === "http://localhost/softzino/api/api/login" || "http://localhost/softzino/api/api/register");
        }
        return false;
    }

    payload(token) {
        const payload = token.split('.')[1];

        return this.decodeToken(payload);
    }

    decodeToken(payload) {
        if (this.isBase64(payload)) {
            return JSON.parse(atob(payload));
        }
        return false;
    }

    isBase64(str) {
        try {
            return btoa(atob(str)).replace(/=/g, "") == str;
        } catch (error) {
            return false;
        }
    }
}

// eslint-disable-next-line no-class-assign
export default Token = new Token();
