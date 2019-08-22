// Core
import React, {Component} from "react";

export default class Cell extends Component {
    _makeMove = () => {
        const { actions, row, column, value, gameOver } = this.props;

        if (!value && !gameOver) {
            actions.makeMoveAsync(row, column);
        }
    };

    render () {
        const {
            value,
            row,
            column
        } = this.props;

        return (
            <div
                role="button"
                tabIndex={ 0 }
                key={ row + '_' + column }
                onClick={ () => this._makeMove() }
                onKeyPress={ () => this._makeMove() }
            >
                {value}
            </div>
        );
    }
}
