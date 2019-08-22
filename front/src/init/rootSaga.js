// Core
import { all, call } from "redux-saga/effects";

// Watchers
import { watchGame } from "../bus/game/saga/watchers";

export function* rootSaga () {
    yield all([
        call(watchGame)
    ]);
}
