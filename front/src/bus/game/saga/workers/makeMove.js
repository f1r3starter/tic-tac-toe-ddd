// Core
import { put, apply, select } from 'redux-saga/effects';

// Instruments
import { api } from '../../../../REST';
import { gameActions } from '../../../game/actions';
import { captionActions } from '../../../caption/actions';

export function* makeMove({ payload: { row, column } }) {
  try {
    const state = yield select();

    yield put(captionActions.nextMove('Bot'));
    yield put(
      gameActions.makeMove(row, column, state.caption.get('playerSign'))
    );

    const response = yield apply(api, api.makeMove, [{ row, column }]);
    const { error, boardState, isOver, playerSign, winner } = yield apply(
      response,
      response.json
    );

    if (response.status !== 200 || error) {
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
