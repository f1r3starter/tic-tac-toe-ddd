// Types
import {types} from "./types";

export const gameActions = {
    // Sync
    makeMove: (row, column, sign) => {
        return {
            type: types.MAKE_MOVE,
            payload: {row, column, sign}
        };
    },
    fillBoard: (board) => {
        return {
            type: types.FILL_BOARD,
            payload: board,
        };
    },
    resetBoard: () => {
        return {
            type: types.RESET_BOARD,
        };
    },
    gameOver: () => {
        return {
            type: types.GAME_OVER,
        }
    },

    // Async
    makeMoveAsync: (row, column) => {
        return {
            type: types.MAKE_MOVE_ASYNC,
            payload: { row, column }
        };
    },
    chooseSignAsync: (sign) => {
        return {
            type: types.CHOOSE_SIGN_ASYNC,
            payload: sign
        };
    },
    getStateAsync: (state) => {
        return {
            type: types.GET_STATE_ASYNC,
            payload: state,
        };
    },
    resetBoardAsync: () => {
        return {
            type: types.RESET_BOARD_ASYNC,
        };
    },
};
