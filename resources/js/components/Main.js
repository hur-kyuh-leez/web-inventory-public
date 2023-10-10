import PropTypes from 'prop-types';
import React from 'react';
import ReactDom from 'react-dom';
import { connect, Provider } from 'react-redux';
import Header from './header';
import TreeContainer from './treeContainer';
import json from '../json';
import Store from '../Reducers/store';
import { resize } from '../Reducers/actions';


window.onresize = resize;

class Main extends React.PureComponent {
    static propTypes = {
        activeNode: PropTypes.string,
        filter: PropTypes.string.isRequired,
        height: PropTypes.number.isRequired,
        width: PropTypes.number.isRequired
    };

    render() {
        return (
            <div id="container">
                <TreeContainer
                    activeNode={this.props.activeNode}
                    data={json}
                    filter={this.props.filter}
                    height={this.props.height}
                    width={this.props.width}/>
            </div>
        );
    }
}

Main = connect(state => state)(Main);

ReactDom.render(
    <Provider store={Store}>
        <Main/>
    </Provider>,
    document.getElementById('main')
);
