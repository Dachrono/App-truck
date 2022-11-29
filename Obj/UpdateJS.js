const formulario = document.getElementById('formulario');
const inputs = formulario.querySelectorAll('.entrada');

console.log(formulario);
console.log(inputs);

const expresiones = {
  company: /^[a-zA-ZÀ-ÿ\s]{1,45}$/,
  nombre: /^[a-zA-ZÀ-ÿ\s]{1,45}$/,
  telefono: /^\d{7,11}$/,
  correo: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
  direccion: /^[a-zA-ZÀ-ÿ0-9.#\s]{1,45}$/,
  z_code: /^\d{5}$/,
  ciudad: /^[a-zA-ZÀ-ÿ\s]{1,45}$/,
  estado: /^[a-zA-ZÀ-ÿ\s]{1,45}$/
}

const validarEntrada = function(e){
  console.log(e.target.name);
  switch (e.target.name){
    case 'company':
      validarCampo(expresiones.company, e.target, 'company');
    break;

    case 'nombre':
      validarCampo(expresiones.nombre, e.target, 'nombre');
    break;

    case 'telefono':
      validarCampo(expresiones.telefono, e.target, 'telefono');
    break;

    case 'email':
      validarCampo(expresiones.correo, e.target, 'email');
    break;

    case 'addrss':
      validarCampo(expresiones.direccion, e.target, 'addrss');
    break;

    case 'cod_postal':
      validarCampo(expresiones.z_code, e.target, 'cod_postal');
    break;

    case 'ciudad':
      validarCampo(expresiones.ciudad, e.target, 'ciudad');
    break;

    case 'estado':
      validarCampo(expresiones.estado, e.target, 'estado');
    break;
  }
}

const validarCampo = function (expresion, input, campo) {
  if (expresion.test(input.value)) {
    document.getElementById(`grupo_${campo}`).classList.remove('formulario_grupo-incorrecto');
    document.getElementById(`grupo_${campo}`).classList.add('formulario_grupo-correcto');
    document.querySelector(`#grupo_${campo} i`).classList.remove('fa-times-circle');
    document.querySelector(`#grupo_${campo} i`).classList.add('fa-check-circle');
    document.querySelector(`#grupo_${campo} .formulario_mensaje`).classList.remove('formulario_mensaje-activo');
    campos[campo]=true;
  }else {
    document.getElementById(`grupo_${campo}`).classList.add('formulario_grupo-incorrecto');
    document.getElementById(`grupo_${campo}`).classList.remove('formulario_grupo-correcto');
    document.querySelector(`#grupo_${campo} i`).classList.remove('fa-check-circle');
    document.querySelector(`#grupo_${campo} i`).classList.add('fa-times-circle');
    document.querySelector(`#grupo_${campo} .formulario_mensaje`).classList.add('formulario_mensaje-activo');
    console.log('Aqui llego');
    campos[campo]=false;
  }
}


inputs.forEach( function(input){
  input.addEventListener ('keyup', validarEntrada);
  input.addEventListener ('blur', validarEntrada);
});
