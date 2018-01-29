import React from 'react';
import Paper from 'material-ui/Paper';
import Menu from 'material-ui/Menu';
import MenuItem from 'material-ui/MenuItem';
import Divider from 'material-ui/Divider';
import { Link } from 'react-router-dom';

/**
 *  @description - main menu component
 */
module.exports = class MenuMenu extends React.Component{

    constructor(props){
        super(props);
        this.call_overview = this.call_overview.bind(this);
        this.call_network = this.call_network.bind(this);
        this.call_mac = this.call_mac.bind(this);
        this.hide_menu = this.hide_menu.bind(this);  
    }

    hide_menu(name){
        this.props.handler(1);
        setTimeout(()=>{
            this.props.titleHandler(name);
        },200);
    }

    call_overview(e){
        e.preventDefault();
        this.hide_menu("Overview");
    }

    call_network(e){
        e.preventDefault();
        this.hide_menu("about the Network");
    }

    call_mac(e){
        e.preventDefault();
        this.hide_menu("about Mac-Addresses");
    }

    render(){
        return(
            <div>
                <Paper className="mm-default mm-show">
                <Menu desktop={true}>
                    <MenuItem onClick={this.call_overview} ><Link to="/">Devices Overview</Link></MenuItem>
                    <MenuItem onClick={this.call_network} ><Link to="/network">about the Network</Link></MenuItem>
                    <MenuItem primaryText="about Mac-Addresses" disabled={true} ></MenuItem>
                </Menu>
                </Paper>
            </div>
        );
    }
}