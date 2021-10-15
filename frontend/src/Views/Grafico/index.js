import { useState,useEffect,Fragment } from 'react';
import ReactDOM from 'react-dom'
import { Button,  Table,Card,CardHeader} from 'reactstrap';
import {  getGraficoGenero, getGraficoHobby,getGraficoNombre,getGraficoTiempoDedicado,getResumen } from './../../api';
import { Link } from 'react-router-dom';
import { Bar,Pie  } from 'react-chartjs-2';

export const Grafico = () => {
  const [dataGenero, setDataGenero] = useState({});
  const [dataHobbie, setDataHobbie] = useState({});
  const [dataGraficoNombre, setDataGraficoNombre] = useState({});
  const [dataGraficoTiempoDedicado, setDataGraficoTiempoDedicado] = useState({});
  
  const [graficoGenero, setGraficoGenero] = useState([]);
  const [graficoHobby, setGraficoHobby] = useState([]);
  const [graficoNombre, setGraficoNombre] = useState([]);
  const [graficoTiempoDedicado, setGraficoTiempoDedicado] = useState([]);
  const [resumen, setResumen] = useState([]);
  const [optionsGrafNombre, setOptionsGrafNombre] = useState({});
  
  const handleGetgetGraficoGenero = async () => setGraficoGenero(await getGraficoGenero());
  const handleGetgetGraficoHobby = async () => setGraficoHobby(await getGraficoHobby());
  const handleGetGraficoNombre = async () => setGraficoNombre(await getGraficoNombre());
  const handleGetGraficoTiempoDedicado = async () => setGraficoTiempoDedicado(await getGraficoTiempoDedicado());
  const handleGetResumen = async () => setResumen(await getResumen());
  const coloresBasicos =["red","green","yellow","blue","orange"];
  useEffect(() => {
    handleGetgetGraficoGenero();
    handleGetgetGraficoHobby();
    handleGetGraficoNombre();
    handleGetGraficoTiempoDedicado();
    handleGetResumen();
  },[]);

  useEffect(() => {
    if(graficoGenero.length > 0){
      let data = mapeoGrafio(graficoGenero);
    
      setDataGenero(data);
      
    };
    
  },[graficoGenero]);

  useEffect(() => {
    
    if(graficoHobby.length > 0){

      let data = mapeoGrafio(graficoHobby);
      
      setDataHobbie(data);
      
    };
    
  },[graficoHobby]);

  useEffect(() => {
    if(graficoNombre.length > 0){

      let data = mapeoGrafio(graficoNombre);
      
      setDataGraficoNombre(data);
      const options = {
        indexAxis: 'y',
        responsive: true,
        
      };
      setOptionsGrafNombre(options)
      
    };

    

    
  },[graficoNombre]);

  useEffect(() => {
    if(graficoTiempoDedicado.length > 0){

      let data = mapeoGrafio(graficoTiempoDedicado);
      
      setDataGraficoTiempoDedicado(data);
      
    };

    

    
  },[graficoTiempoDedicado]);
  const mapeoGrafio = (array = []) => {
    if(array.length > 0){

      let labels = [];
      array.map((grafico, i) => {
        labels.push(grafico.name)
      })
      let datasetsAux = [];
      let index = 0;
      let objGraf = {
        label: "",
        data: [],
        backgroundColor: [],
      } 
      array.map((grafico, i) => {
        
        
        objGraf.data.push(grafico.cantidad);
        objGraf.backgroundColor.push(coloresBasicos[i]  ? coloresBasicos[i] :  colorHEX())
        
        
      })
     
      return {labels:labels,datasets:[objGraf]};
      
    }
    return {};
  }
  const handleExportar = () => {
    
    window.location.href = `${process.env.REACT_APP_ENDPOINT_LARAVEL_ENCUESTAS}/respuestas/excel`;
  }
  const colorHEX = () => {
    var coolor = "";
    for(var i=0;i<6;i++){
      coolor = coolor + generarLetra() ;
    }
    return "#" + coolor;
  }

  const generarLetra = () => {
    var letras = ["a","b","c","d","e","f","0","1","2","3","4","5","6","7","8","9"];
    var numero = (Math.random()*15).toFixed(0);
    return letras[numero];
  }
  return (
    <Fragment>
      <div className= "row">
          <div className="col">
              <div className="card">
            
                <div className="card-body">
                  <h5 className="card-title">Cantida de personas por genero</h5>
                  <Pie  data={dataGenero} />
                  
                </div>
              </div>
          </div>
          <div className="col">
            <div className="card">
              
              <div className="card-body">
                <h5 className="card-title">Cantida de hobby</h5>
                <Bar  data={dataHobbie} />
                
              </div>
            </div>
          </div>
      </div>
      <br/>
      <div className= "row">
          <div className="col">
              <div className="card">
            
                <div className="card-body">
                  <h5 className="card-title">Nombres mas Frecuentes</h5>
                  <Bar  data={dataGraficoNombre} options={optionsGrafNombre} />
                  
                </div>
              </div>
          </div>
          <div className="col">
            <div className="card">
              
              <div className="card-body">
                <h5 className="card-title">Tiempo dedicado al Hobby mas frecuente</h5>
                <Bar  data={dataGraficoTiempoDedicado}  />
                
              </div>
            </div>
          </div>
      </div>
      <br/>
      <div className= "row">
          <div className="col">
              <div className="card">
              <div class="card-header">
                  Resumen
                  <button style={{float: "right"}} onClick={(e) => {handleExportar()}} value="button"  className="btn btn-primary">Exportar</button>
              </div>
                <div className="card-body">
                  
                  <table className="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col">Pregunta</th>
                        <th scope="col">Respuesta</th>
                      </tr>
                    </thead>
                    <tbody>
                        {
                        resumen.map((data, i) => {
                          return <tr>
                              <td>{data.pregunta}</td>
                              <td>{data.respuesta ? data.respuesta : data.text_resp}</td>
                          </tr>
                        })
                        }
                    </tbody>
                  </table>
                </div>
              </div>
          </div>
          
      </div>
      
    </Fragment>
  );
}