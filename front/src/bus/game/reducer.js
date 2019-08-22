// Core
import {fromJS, List, Map} from "immutable";
// Types
import { types } from "./types";

const initialState = Map({
    nextMove: false,
    gameOver: false,
    cells:   List([List(['', '', '']), List(['', '', '']), List(['', '', ''])]),
    caption: '',
});

export const gameReducer = (state = initialState, action) => {
    switch (action.type) {
        case types.MAKE_MOVE:
            const { row, column, sign } = action.payload;

            return state.setIn(['cells', row, column], sign);

        case types.FILL_BOARD:
            return state.set('cells', fromJS(action.payload));

        case types.RESET_BOARD:
            return initialState;

        case types.GAME_OVER:
            return state.set('gameOver', true);

        default:
            return state;
    }
};
