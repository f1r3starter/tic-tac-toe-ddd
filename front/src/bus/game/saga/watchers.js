// Core
import { takeEvery, all, call } from "redux-saga/effects";

// Types
import { types } from "../types";

// Workers
import {chooseSign, getState, makeMove, resetBoard} from "./workers";

function* watchChooseSign () {
    yield takeEvery(types.CHOOSE_SIGN_ASYNC, chooseSign);
}

function* watchMakeMove () {
    yield takeEvery(types.MAKE_MOVE_ASYNC, makeMove);
}

function* watchGetState () {
    yield takeEvery(types.GET_STATE_ASYNC, getState);
}

function* watchResetBoard() {
    yield takeEvery(types.RESET_BOARD_ASYNC, resetBoard);
}

export function* watchGame () {
    yield all([
        call(watchChooseSign),
        call(watchMakeMove),
        call(watchGetState),
        call(watchResetBoard),
    ]);
}
