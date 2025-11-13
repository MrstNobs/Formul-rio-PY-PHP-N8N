import { useNavigate } from "react-router-dom";
import { useState } from "react";

const Recuperar = () => {
    const navigate = useNavigate();

    const [email_update, setEmail_Update] = useState('');
    const [senha_update, setSenha_Update] = useState('');

    const handleSubmit = async (e) => {
        e.preventDefault();

        const data = {email_update, senha_update};

        try{
            const URL = import.meta.env.VITE_PY_UPDATE;
            const requisicao = await fetch(URL, {
                method: 'PUT',
                headers: {'content-type': 'application/json'},
                body: JSON.stringify(data)
            });

            const resultado = await requisicao.json();
            if(resultado.success){
                alert(resultado.message);
            } else{
                alert(resultado.message);
            }

            navigate("/")
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

export default Recuperar;