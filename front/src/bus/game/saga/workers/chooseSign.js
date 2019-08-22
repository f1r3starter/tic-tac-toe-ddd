// Core
import { put, apply } from "redux-saga/effects";

// Instruments
import { api } from "../../../../REST";
import { gameActions } from "../../../game/actions";
import { captionActions } from "../../../caption/actions";

export function* chooseSign ({ payload: sign }) {
    try {
        const response = yield apply(api, api.chooseSign, [sign]);
        const { error, boardState  } = yield apply(response, response.json);

        if (response.status !== 200 && error) {
            throw new Error(error);
        }

        yield put(gameActions.fillBoard(boardState));
        yield put(captionActions.setPlayerSign(sign));
        yield put(captionActions.nextMove(`You (${sign})`));
    } catch (error) {
        yield put(captionActions.showError(error.message));
    }
}
