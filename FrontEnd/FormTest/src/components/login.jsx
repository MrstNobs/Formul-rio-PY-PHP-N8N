// import { useState } from 'react';
import { useState } from 'react';
import { Link } from 'react-router-dom'
import { useNavigate } from 'react-router-dom';

const Login = () => {
  const navegate = useNavigate();

  const [email_login, setEmail_Login] = useState('');
  const [senha_login, setSenha_Login] = useState('');

  const EnviarLogin = async (e) => {
    e.preventDefault();

    // Cria um Objeto
    const data = {
      action: 'login',
      email_login, 
      senha_login
    };

    try{
      // Faz uma reqsuisiçaõ
      const URL = import.meta.env.VITE_URL_PHP_LOGIN;
      const requisicao = await fetch(URL, {
        method: 'POST',
        headers: {'content-type': 'application/json'},
        body: JSON.stringify(data)
      });

      // faz validação da resuqisação
      const resultado = await requisicao.json();
      if(resultado.success){
        alert(resultado.message);

        const email_hidden = resultado.email_hidden;
        navegate("/mensagem", { state: { key: email_hidden}});
      } else{
        alert(resultado.message);
      }

      // Navega ata proxima págima Mensagem
    }catch(e){
      console.error("Error", e);
    }
  }

  return (
    <div className='container-main'>
      <form onSubmit={EnviarLogin}>
        <h1>Login</h1>

        <div className='inputBox'>
          <input 
            placeholder='Digite seu email' 
            type='email'
            value={email_login}
            onChange={(e)=>setEmail_Login(e.target.value)}
          />
          <i className='bx bxs-user'></i>
        </div>

        <div className='inputBox'>
          <input 
            placeholder='Digite sua senha' 
            type='password'
            value={senha_login}
            onChange={(e)=>setSenha_Login(e.target.value)}
            />
          <i className='bx bxs-lock-alt'></i>
        </div>

        <div className='remember-forgot'>
          <label>
            <input type="checkbox"/> Lembrar senha
          </label>
          <Link to='/recuperar'>Esqueci a Senha</Link>
        </div>

        <button type='submit' className='login'>Login</button>

        <div className='register-link'>
          <p>Não possui uma conta? <Link to='/cadastro'>Cadastrar</Link> </p>
        </div>

      </form>
    </div>
  )
}

export default Login;