// Core
import { put } from "redux-saga/effects";

// Instruments
import { gameActions } from "../../../game/actions";
import { captionActions } from "../../../caption/actions";

export function* resetBoard () {
        yield put(gameActions.resetBoard());
        yield put(captionActions.resetCaption());
}
