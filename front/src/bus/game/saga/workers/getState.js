// Core
import { put, apply } from 'redux-saga/effects';

// Instruments
import { api } from '../../../../REST';
import { gameActions } from '../../../game/actions';
import { captionActions } from '../../../caption/actions';

export function* getState() {
  try {
    const response = yield apply(api, api.getState);
    const { error, boardState, isOver, playerSign, winner } = yield apply(
      response,
      response.json
    );

    if (response.status !== 200 && error) {
      throw new Error(error);
    }

    yield put(gameActions.fillBoard(boardState));
    yield put(captionActions.setPlayerSign(playerSign));
    yield put(captionActions.nextMove(`You (${playerSign})`));
    if (isOver) {
      yield put(captionActions.showResult(winner, isOver));
      yield put(gameActions.gameOver());
    }
  } catch (error) {
    yield put(captionActions.showError(error.message));
  }
}
