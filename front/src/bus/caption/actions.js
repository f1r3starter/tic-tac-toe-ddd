// Types
import {types} from "./types";

export const captionActions = {
    // Sync
    setPlayerSign: (sign) => {
        return {
            type: types.SET_PLAYER_SIGN,
            payload: sign
        };
    },
    showResult: (winner, isOver) => {
        return {
            type: types.SHOW_RESULT,
            payload: { winner, isOver }
        };
    },
    resetCaption: () => {
        return {
            type: types.RESET_CAPTION,
        };
    },
    showError: (error) => {
        return {
            type: types.SHOW_ERROR,
            payload: error
        };
    },
    nextMove: (player) => {
        return {
            type: types.NEXT_MOVE,
            payload: player
        };
    },
};
