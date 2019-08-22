// Core
import React, {Component} from "react";
import {connect} from "react-redux";
import {bindActionCreators} from "redux";
// Components
import {Catcher, Cell, Info } from "../../components";
// Actions
import {gameActions} from "../../bus/game/actions";

const mapStateToProps = (state) => {
    return {
        cells: state.game.get('cells'),
        caption: state.caption.get('caption'),
        playerSign: state.caption.get('playerSign'),
        gameOver: state.game.get('gameOver'),
    };
};

const mapDispatchToProps = (dispatch) => {
    return {
        actions: bindActionCreators(
            {...gameActions},
            dispatch
        ),
    };
};

class Board extends Component {
    componentDidMount() {
        const { actions } = this.props;

        actions.getStateAsync();
    }

    render() {
        const {actions, cells, playerSign, caption, gameOver } = this.props;

        const cellsJSX = cells.map((row, rowIndex) => {
            return row.map((cell, cellIndex) => {
                return (
                    <Catcher key={rowIndex + '_' + cellIndex}>
                        <Cell
                            actions={actions}
                            column={cellIndex}
                            gameOver={gameOver}
                            value={cell}
                            row={rowIndex}
                        />
                    </Catcher>
                );
            })
        });

        return (
                <div>
                    <div className="grids">
                        {cellsJSX}
                    </div>

                    <Info actions= { actions } caption = { caption } playerSign = {playerSign} />
                </div>
        );
    };
}

export default connect(mapStateToProps, mapDispatchToProps)(Board);
