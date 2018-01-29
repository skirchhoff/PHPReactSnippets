'use strict';

const React = require('react');
const ReactDOM = require('react-dom');
const PropTypes = require('prop-types');

import {
    TableRow,
    TableRowColumn,
  } from 'material-ui/Table';

/**
 *  @description - port table row element component
 */
module.exports = class NDMVOverviewDevicecardPorts extends React.Component{

    constructor(props){
        super(props);
    }

    render(){
        return(
            <TableRow>
                <TableRowColumn>{this.props.port}</TableRowColumn>
                <TableRowColumn>{this.props.service}</TableRowColumn>
                <TableRowColumn><a href={this.props.url}>{this.props.url}</a></TableRowColumn>
            </TableRow>
        );
    }
}