'use strict';

const React = require('react');
const ReactDOM = require('react-dom');
const PropTypes = require('prop-types');
const DeviceCard = require('./NDMVOverviewDevicecard');
const Axios = require('axios');

/**
 *  Devices overview block component
 */
module.exports = class NDMVOverview extends React.Component {

    constructor(props){
      super(props);
      this.state = {
        devices:[]
      }
    }

    componentDidMount() {
      this.updateDeviceList();
    }

    updateDeviceList(){
      Axios.get(`http://127.0.0.1:8080/data/devices`)
        .then(res => {
          this.setState({ devices:res.data });
      });
    }

    render() {
      return (
        <div style={{paddingTop:80, paddingBottom:40}}>
        {
          this.state.devices.map( (d,i) =>
            <DeviceCard 
              key={i}
              name={d.name} 
              ip={d.ip} 
              mac={d.mac} 
              manufacturer={d.manufacturer!=null?d.manufacturer.manufacturer:"MULTICAST-DEVICE"} 
              ports={d.ports}
            />  
          )
        }
        </div>
      );
    }
  }