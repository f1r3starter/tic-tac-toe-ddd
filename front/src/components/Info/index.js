// Core
import React, {Component} from "react";

export default class Info extends Component {
    _chooseX = () => this.props.actions.chooseSignAsync('X');
    _chooseO = () => this.props.actions.chooseSignAsync('O');
    _resetBoard = () => this.props.actions.resetBoardAsync();

    render() {
        const { playerSign, caption } = this.props;

        const buttonsJSX = !playerSign ?
            <div>
                <h3>
                    Choose your destiny:
                </h3>
                <button type="button" onClick={ this._chooseX } onKeyPress={ () => this._chooseX() }>
                    X
                </button>
                <button type="button" onClick={ this._chooseO }>
                    O
                </button>
            </div>
            :

            <div>
                <h3>
                    { caption }
                </h3>
                <button
                    type="button"
                    onClick={ this._resetBoard }
                >
                    Reset
                </button>
            </div>
        ;

        return (
            <div className="info">
                {buttonsJSX}
            </div>
        );
    };
}
