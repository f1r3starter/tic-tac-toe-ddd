// Core
import React, { Component } from 'react';
// Instruments
import Styles from './styles.m.css';

export default class Catcher extends Component {
  state = {
    error: false
  };

  componentDidCatch(error, stack) {
    console.log('ERROR:', error.message);
    console.log('STACKTRACE:', stack.componentStack);

    this.setState({
      error: true
    });
  }

  render() {
    const { error } = this.state;
    const { children } = this.props;

    if (error) {
      return (
        <section className={Styles.catcher}>
          <span>An error occurred.</span>
        </section>
      );
    }

    return children;
  }
}
