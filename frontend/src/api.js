

const urlGetEncuestas = `${process.env.REACT_APP_ENDPOINT_LARAVEL_ENCUESTAS}/encuestas`;
const urlGetRespuestas = `${process.env.REACT_APP_ENDPOINT_LARAVEL_ENCUESTAS}/respuestas`;


const getHeader = ()=>{
  let header = { };
  header["Content-Type"] = "application/json";
  //if(Cookies.get("access_token"))
      //header["Authorization"] = "Bearer "+Cookies.get("access_token");

  return header;
}

export const getEncuestas = async () => {
  let response = await fetch(urlGetEncuestas);
  response = await response.json();
  return response;
}

export const saveEncuesta = async (encuesta) => {
  let formData = new FormData();
  
  
  encuesta.map((pregunta,key) => {
    let data = []
    
    formData.append('encuesta['+key+'][id_pregunta]', pregunta.id_pregunta);
    if(pregunta.alternativa)
      formData.append('encuesta['+key+'][id_respuesta]', pregunta.id_respuesta); 
    else
      formData.append('encuesta['+key+'][value]', pregunta.value);
    formData.append('encuesta['+key+'][alternativa]', pregunta.alternativa);
  } );
  
  var options = {
    method: 'POST',
    body: formData,
    redirect: 'follow'
  };
  let response = await fetch(urlGetEncuestas, options );
  response = await response.json();
  
  return response;
}

export const getRespuestaByIdParticipante = async (id) => {
  
  let response = await fetch(urlGetRespuestas+"/"+id);
  response = await response.json();
  return response;
}

export const updateClients = async (user) => {
  let formData = new FormData();
  
  formData.append("name",user.name);
  formData.append("paterno",user.paterno);
  formData.append("rut",user.rut);
  var options = {
    method: 'POST',
    body: formData,
    redirect: 'follow'
  };
  let response = await fetch(urlGetEncuestas+"/update/"+user.id, options );
  return response;
}

export const getGraficoGenero = async () => {
  let response = await fetch(urlGetRespuestas+"/graficoGenero");
  response = await response.json();
  return response;
}

export const getGraficoHobby = async () => {
  let response = await fetch(urlGetRespuestas+"/graficoHobby");
  response = await response.json();
  return response;
}
export const getGraficoNombre = async () => {
  let response = await fetch(urlGetRespuestas+"/graficoNombres");
  response = await response.json();
  return response;
}
export const getGraficoTiempoDedicado = async () => {
  let response = await fetch(urlGetRespuestas+"/graficoTiempoDedicado");
  response = await response.json();
  return response;
}
export const getResumen = async () => {
  let response = await fetch(urlGetRespuestas);
  response = await response.json();
  return response;
}


