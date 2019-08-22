// Instruments
import {MAIN_URL} from "./config";

export const api = {
    makeMove(move) {
        return fetch(`${MAIN_URL}`, {
            method: "PUT",
            credentials: 'include',
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(move),
        });
    },
    getState() {
        return fetch(`${MAIN_URL}`, {
            credentials: 'include',
            method: "GET"
        });
    },
    chooseSign(sign) {
        return fetch(`${MAIN_URL}`, {
            credentials: 'include',
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ sign }),
        });
    },
};
