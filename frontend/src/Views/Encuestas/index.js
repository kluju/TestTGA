import { useState,useEffect,Fragment } from 'react';
import { Button,  Table,Card,CardHeader,Label,Form,Input,FormGroup,CardBody,CardFooter,Row, Alert} from 'reactstrap';
import {  getEncuestas,saveEncuesta } from '../../api';
import { Link } from 'react-router-dom';
export const Encuestas = () => {
  
  const [encuestas, setEncuestas] = useState([]);
  const [displaySelHobby, setDisplaySelHobby] = useState(false)
  const [preguntaRespuesta, setPreguntaRespuesta] = useState([]);
  const [encustaRespuestas, setEncustaRespuestas] = useState([]);

  const [respuestaByIdParticipante, setRespuestaByIdParticipante] = useState([]);
  
  const handleGetEncuestas = async () => setEncuestas(await getEncuestas());
  const handleSaveEncuesta = async (encuesta) => setEncustaRespuestas(await saveEncuesta(encuesta));
  useEffect(() => {
    handleGetEncuestas();
  },[]);

  useEffect(() => {
      
      
      
  },[respuestaByIdParticipante]);

  useEffect(() => {
    if(encustaRespuestas.code == 200){
      alert(encustaRespuestas.mensaje)
    }
},[encustaRespuestas]);
  
  const handleCheck = (checked, id_pregunta, id_respuesta) => {
    const pregResp = {
      id_pregunta,
      id_respuesta,
      alternativa:true
    }
    
    var filter_preguntas = preguntaRespuesta.filter((pregunta) => pregunta.id_pregunta !== id_pregunta );
    
    filter_preguntas.push(pregResp);
      
    setPreguntaRespuesta(filter_preguntas);
    if(id_pregunta == 3 && checked)
      setDisplaySelHobby(true)
  }

  const handleInput = (value, id_pregunta) => {
    const pregResp = {
      id_pregunta,
      value,
      alternativa:false
    }
    var filter_preguntas = preguntaRespuesta.filter((pregunta) => pregunta.id_pregunta !== id_pregunta );
    
    filter_preguntas.push(pregResp);
      
    setPreguntaRespuesta(filter_preguntas);
  }
  const handleSave = (e) => {
    e.preventDefault();
    if(preguntaRespuesta.length  > 0){
      if(preguntaRespuesta.length == 4)
        handleSaveEncuesta(preguntaRespuesta)
    }else{
      alert("Debe completar todas los preguntas")
    }
    //handleSaveEncuesta(preguntaRespuesta)
  }
  
  
  return (
    <Fragment>

      <form onSubmit={(e) => { handleSave(e); }}>
        {
          
        encuestas.map((encuesta, i) => {
            let respuesta = []
            if(encuesta.respuestas != undefined) {

              encuesta.respuestas.map((a, x) => {
                
                respuesta.push( 
                  <div class="mb-3 form-check">
                    <input required type="radio" value={a.id_respuesta} name = {"respuesta_"+encuesta.id_pregunta} class="form-check-input"  onChange={(e) => { handleCheck(e.target.checked,encuesta.id_pregunta, a.id_respuesta); }} />
                    <label class="form-check-label" for="exampleCheck1">{a.respuesta}</label>
                  </div>
                )
              })
            }else{
              
              respuesta = <input required type="text" onChange={(e) => { handleInput(e.target.value,encuesta.id_pregunta); }} className="form-control" key={"input_"+encuesta.id_pregunta}/>
            }
            let display = "block";
            if(encuesta.id_pregunta == 4 && !displaySelHobby){
              display = "none";
            }
              
            return <div className="mb-3"style={{display:display}} >
              <label for="exampleInputEmail1" className="form-label">{encuesta.pregunta}</label>
              {respuesta}
            </div>
        })
        }
        <button  value="Submit"  className="btn btn-primary">Guardar</button>
        <Link className="p-2 text-dark" to="/grafico"><button type="button"  className="btn btn-primary">Siguiente</button></Link>
      </form>
    </Fragment>
  );
}
