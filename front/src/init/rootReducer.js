// Core
import {combineReducers} from "redux";
// Reducers
import {gameReducer as game} from "../bus/game/reducer";
import {captionReducer as caption} from "../bus/caption/reducer";

export const rootReducer = combineReducers({
    game,
    caption,
});
