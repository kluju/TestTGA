import './App.css';
import { useState,useEffect,Fragment } from 'react';
import { JsonToTable } from "react-json-to-table";
import 'bootstrap/dist/css/bootstrap.css';
import {  getClientIds, getClients,getBusiness,getLeases } from './api';
import React from "react";
import { Dropdown, DropdownToggle, DropdownMenu, DropdownItem } from 'reactstrap';
import {
  BrowserRouter as Router,
  Switch,
  Route,
  Link
} from "react-router-dom";
import {Encuestas}from './Views/Encuestas';
import {Grafico}from './Views/Grafico';
const App = () => {
  const [dropdownOpen, setDropdownOpen] = useState(false);

  const toggle = () => setDropdownOpen(prevState => !prevState);
  const [clientIds, setClientIds] = useState([]);
  const [clients, setClients] = useState([]);
  return (<div className="App">
      <main role="main">
            <div className="container">
            <Router>
            <div className="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
              <h5 className="my-0 mr-md-auto font-weight-normal">Prueba TGA</h5>
              <nav className="my-2 my-md-0 mr-md-3">
                <Link className="p-2 text-dark" to="/">Encuestas</Link>
                
                <Link className="p-2 text-dark" to="/grafico">Grafico</Link>
              </nav>
              
            </div>
            <Switch>
            <Route exact path="/">
              <Encuestas />
            </Route>
            
            
            <Route exact path="/grafico" component={Grafico}/>
          </Switch>
          </Router>
            </div> 
      </main>

  </div>)
  
}




export default App;
