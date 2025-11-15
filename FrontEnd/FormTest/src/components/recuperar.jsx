// Imorta bibliotecas de Navegação e State
import { useNavigate } from "react-router-dom";
import { useState } from "react";

const Recuperar = () => {
    // Pega a função da importação
    const navigate = useNavigate();

    // Salvar as informações
    const [email_update, setEmail_Update] = useState('');
    const [senha_update, setSenha_Update] = useState('');

    // Cria uma função
    const handleSubmit = async (e) => {
        // Não recarrega a página
        e.preventDefault();

        // Cria um Objeto
        const data = {email_update, senha_update};

        try{
            // Faz a requisição
            const URL = import.meta.env.VITE_PHP_UPDATE;
            const requisicao = await fetch(URL, {
                method: 'PUT',
                headers: {'content-type': 'application/json'},
                body: JSON.stringify(data)
            });

            // Mostra a validação e faz a navegação para a pagina
            const resultado = await requisicao.json();
            if(resultado.success){
                alert(resultado.message);
                navigate("/")
            } else{
                alert(resultado.message);
            }

        }catch(e){
            console.error("Error", e);
        }

    }

    return (
        <div className='container-main'>
            <form onSubmit={handleSubmit}>
                <h1>Recuperação</h1>

                <div className='inputBox'>
                    <input 
                        placeholder='Digite seu email' 
                        type='email'
                        value={email_update}
                        onChange={(e)=>setEmail_Update(e.target.value)}
                    ></input>
                    <i className='bx bxs-user'></i>
                </div>
  
                <div className='inputBox'>
                    <input 
                        placeholder='Digite sua senha Nova' 
                        type='password'
                        value={senha_update}
                        onChange={(e)=>setSenha_Update(e.target.value)}
                    ></input>
                   <i className='bx bxs-lock-alt'></i>
                </div>

                <button type='submit' className='login'>Atualizar</button>

            </form>
        </div>
    );
};

// exporta o arquivo
export default Recuperar;