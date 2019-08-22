// Core
import { Map } from "immutable";

// Types
import { types } from "./types";

const initialState = Map({
    caption: '',
    playerSign: '',
});

export const captionReducer = (state = initialState, action) => {
    switch (action.type) {
        case types.SHOW_RESULT:
            const { winner, isOver } = action.payload;

            return !winner && isOver ? state.set('caption', 'Draw') : state.set('caption', `Winner is  ${winner}`);

        case types.SET_PLAYER_SIGN:
            return state.set('playerSign', action.payload).set('showChoose', false);

        case types.NEXT_MOVE:
            return state.set('caption', `Next move: ${action.payload}`);

        case types.RESET_CAPTION:
            return initialState;

        case types.SHOW_ERROR:
            return state.set('caption', action.payload);

        default:
            return state;
    }
};
