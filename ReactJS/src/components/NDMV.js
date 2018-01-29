'use strict'

// react modules
const React = require('react');
const ReactDOM = require('react-dom');
const PropTypes = require('prop-types');
import { Route, BrowserRouter } from 'react-router-dom';

// own components
const NDMVOverview = require('./NDMVOverview');
const NDMVAboutMacAddresses = require('./NDMVAboutMacAddresses');
const NDMVAboutNetwork = require('./NDMVAboutNetwork');
const NDMVMainMenu = require('./NDMVMainMenu2');

// Material-UI components
import darkBaseTheme from 'material-ui/styles/baseThemes/darkBaseTheme';
import MuiThemeProvider from 'material-ui/styles/MuiThemeProvider';
import getMuiTheme from 'material-ui/styles/getMuiTheme';
import AppBar from 'material-ui/AppBar';
import IconButton from 'material-ui/IconButton';
import ActionAutorenew from 'material-ui/svg-icons/action/autorenew';

/**
 *  @description - core component,
 */
module.exports = class NDMV extends React.Component {
    
    constructor(){
        super();
        console.log('NDMV');
    
        this.state = { 
            subtitle:"Overview",
            loaderClass:"",
            mainMenuClass:"mm-hide",
            mainMenuActive:false
        };

        this.refresh = this.refresh.bind(this);
        this.toggle_mainmenu = this.toggle_mainmenu.bind(this);
        this.hide_mainmenu = this.hide_mainmenu.bind(this);
        this.set_subtitle = this.set_subtitle.bind(this);
        this.on_load = this.on_load.bind(this);
        this.on_finish_load = this.on_finish_load.bind(this);
    }

    set_subtitle (t){
        this.setState(prevState=>({
            subtitle:t,
            mainMenuActive:false
    }));
    }

    hide_mainmenu(e){
        this.setState(prevState => ({
             mainMenuActive: false
          }));
        console.log("turn off call");
    }

    toggle_mainmenu(e){
        this.setState({
            mainMenuClass:(this.state.mainMenuClass=="mm-default mm-hide"?"mm-default mm-show":"mm-default mm-hide"),
            mainMenuActive:(this.state.mainMenuActive?false:true)
        })
        
    }

    refresh(e){
        this.setState({
            loaderClass:"onload"
        });
    }

    on_load(){
        this.setState({
            loaderClass:"onload"
        });
    }

    on_finish_load(){
        this.setState({
            loaderClass:""
        });
    }


    render() {
        console.log("in ndmv:"+this.state.mainMenuClass);
      return (
        <BrowserRouter>
            <MuiThemeProvider >
                <div>
                    <AppBar 
                        style={{position:'fixed'}}
                        title="Network Device Scanner" 
                        onRightIconButtonClick = {this.refresh}
                        onLeftIconButtonClick = {this.toggle_mainmenu}
                        iconElementRight={<IconButton className={this.state.loaderClass}><ActionAutorenew
                            style={{
                                color:'#fff',
                                marginTop:20,
                                marginRight:10,
                                cursor:'pointer'
                        }} /></IconButton>}
                        children = {<h3 style={{
                                color:'#fff',
                                fontSize:24,
                                position:'absolute',
                                left:330,
                                marginTop:12,
                                opacity:0.5
                            }}
                        >{this.state.subtitle}</h3>}
                    />
                    <div>
                            { this.state.mainMenuActive? <NDMVMainMenu titleHandler={this.set_subtitle} handler={this.hide_mainmenu} /> : null }
                        <div className="content">
                            <Route exact path="/" component={NDMVOverview}/>
                            <Route path="/mac-addresses" component={NDMVAboutMacAddresses}/>
                            <Route path="/network" component={NDMVAboutNetwork}/>
                        </div>
                    </div>
                </div>
            </MuiThemeProvider>
        </BrowserRouter>
      );
    }
}