'use strict';

const React = require('react');
const ReactDOM = require('react-dom');
const PropTypes = require('prop-types');

import {
    Table,
    TableBody,
    TableHeader,
    TableHeaderColumn,
    TableRow,
    TableRowColumn,
  } from 'material-ui/Table';
import {Card, CardActions, CardHeader, CardText, CardTitle} from 'material-ui/Card';
import Paper from 'material-ui/Paper';
import Badge from 'material-ui/Badge';
import NDMVOverviewDevicecardPorts from './NDMVOverviewDevicecardPorts';

/**
 *  Device info block component
 */
module.exports = class DeviceCard extends React.Component{

    constructor(props){
        super(props);
    }

    render(){ return (
        <div className="overview-device-card">
        <Paper  rounded={false} >
            <Card>
                <CardTitle title={this.props.name} subtitle={this.props.ip} style={{paddingBottom:0}} />
                <CardHeader
                    title={this.props.manufacturer}
                    subtitle={this.props.mac}
                    actAsExpander={this.props.ports.length > 0}
                    showExpandableButton={this.props.ports.length > 0}
                    children={<Badge
                        badgeContent={this.props.ports.length}
                        primary={true}
                        badgeStyle={{top:12}}
                        style={{float:'right',marginRight:80, marginTop:-5,}}
                        badgeStyle={(this.props.ports.length>0?{backgroundColor:'#B71C1C'}:{backgroundColor:'#cdcdcd'})}
                    />}
                />
                {
                    this.props.ports.length > 0 ?
                    <CardText expandable={true}>
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHeaderColumn>Service Name</TableHeaderColumn>
                                    <TableHeaderColumn>Port</TableHeaderColumn>
                                    <TableHeaderColumn>Test Url</TableHeaderColumn>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {
                                    this.props.ports.map((d)=>
                                        <NDMVOverviewDevicecardPorts port={d.port} service={d.service} url={"http://127.0.0.1:"+d.port} />  
                                    )
                                }
                                
                            </TableBody>
                        </Table>
                    </CardText> :null
                }
            </Card>
        </Paper>
        </div>);
    }
}
