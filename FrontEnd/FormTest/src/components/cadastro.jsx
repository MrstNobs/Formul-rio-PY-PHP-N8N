import { useState } from "react";
import { useNavigate } from "react-router-dom";

const Cadastro = () => {
  // Função de Navegaação
  const navegacao = useNavigate();

  const [email_cadastro, setEmail_Cadastro] = useState('');
  const [senha_cadastro, setSenha_Cadastro] = useState('');

  const handleSubmit = async (e) => {
    e.preventDefault();

    const data = {
      action:'cadastro',
      email_cadastro, 
      senha_cadastro
    };

    try{
      // Monta uma reuisição em JSON para o Pyhton
      const URL = import.meta.env.VITE_URL_PY_CADASTRAR;
      const requisicao = await fetch(URL, {
        method: 'POST',
        headers: {'content-type': 'application/json'},
        body: JSON.stringify(data)
      });

      //Validação de Envio da requsiçao
      const resultado = await requisicao.json();
      if(resultado.success){
        alert(resultado.message);
      } else{
        alert(resultado.message);
      }
    
      // Manda de volta para o Login
      navegacao("/");
    } catch(e){
        console.error("Error", e);
    }
      
  };

  return (
    <div className='container-main'>
      <form onSubmit={handleSubmit}>
        <h1>Cadastro</h1>

        <div className='inputBox'>
          <input 
            placeholder='Digite seu email' 
            type='email'
            value={email_cadastro}
            onChange={(e)=>setEmail_Cadastro(e.target.value)}
            ></input>
          <i className='bx bxs-user'></i>
        </div>
  
        <div className='inputBox'>
          <input 
            placeholder='Digite sua senha' 
            type='password'
            value={senha_cadastro}
            onChange={(e)=>setSenha_Cadastro(e.target.value)}
            ></input>
          <i className='bx bxs-lock-alt'></i>
        </div>

        <button type='submit' className='login'>Cadastrar</button>

      </form>
    </div>
  );
}
export default Cadastro;