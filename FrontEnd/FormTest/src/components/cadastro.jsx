// Importa bibliotecas State e Navegação
import { useState } from "react";
import { useNavigate } from "react-router-dom";

const Cadastro = () => {
  // Pega a função da importação
  const navegacao = useNavigate();

  // Salva as informações
  const [email_cadastro, setEmail_Cadastro] = useState('');
  const [senha_cadastro, setSenha_Cadastro] = useState('');

  // Cria uma função
  const handleSubmit = async (e) => {
    // Nãp recarrega a página
    e.preventDefault();

    // Cria um Objeto
    const data = {
      action:'cadastro',
      email_cadastro, 
      senha_cadastro
    };

    try{
      // Faz um requisição
      const URL = import.meta.env.VITE_URL_PHP_CADASTRAR;
      const requisicao = await fetch(URL, {
        method: 'POST',
        headers: {'content-type': 'application/json'},
        body: JSON.stringify(data)
      });

      // Valida a requisição, mostra na tela e nevega para outra página
      const resultado = await requisicao.json();
      if(resultado.success){
        alert(resultado.message);
        navegacao("/");
      } else{
        alert(resultado.message);
      }
    
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

// Exporta o arquivo 
export default Cadastro;