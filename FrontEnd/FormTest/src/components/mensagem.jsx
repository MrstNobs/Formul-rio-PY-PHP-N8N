// Importa Biblioteca State Locação e Navegação
import { useState } from "react";
import { useLocation } from "react-router-dom";
import { useNavigate } from "react-router-dom";

const Mensagem = () => {
    // Pega a função da importação
    const navigate = useNavigate();

    // Salva as informações
    const [email_dstny, setEmail_Dstny] = useState('');
    const [nome_dstny, setNome_Dstny] = useState('');
    const [msg_dstny, setMsg_Dstny] = useState('');

    // Pega a função da importação e depois pega a informações
    const location = useLocation();
    const email_prop = location.state?.key;

    // Cria uma função
    const handleSubmit = async (e) => {
        // Não recarrega a página
        e.preventDefault();

        // Cria um objeto
        const data = {
            email_prop,
            email_dstny, 
            nome_dstny, 
            msg_dstny
        }

        try{
            // Faz a requisição
            const URL = import.meta.env.VITE_PHP_MSG;
            const requisicao = await fetch(URL, {
                method: 'POST',
                headers: {'content-type': 'application/json'},
                body: JSON.stringify(data)
            });

            // Faz a validação da requisição e mostra na tela e faz a nevegação para outra página
            const resultado = await requisicao.json();
            if(resultado.success){
                alert(resultado.message);
                navigate("/");
            } else{
                alert(resultado.message);
            }

        }catch(e){
            console.error("Error", e);
        }
    };

    return (
        <div className='container-main'>
            <form onSubmit={handleSubmit}>
                <h1>Mensagem</h1>

                <div className='inputBox'>
                    <input 
                        placeholder='Email da pessoa' 
                        type='email'
                        value={email_dstny}
                        onChange={(e)=>setEmail_Dstny(e.target.value)}
                    />
                </div>

                <div className='inputBox'>
                    <input 
                        placeholder='Digite o nome da pessoa'
                        value={nome_dstny}
                        onChange={(e)=>setNome_Dstny(e.target.value)}
                        />
                </div>

                <div className='inputBox'>
                    <input 
                        placeholder='Digite sua mensagem'
                        value={msg_dstny}
                        onChange={(e)=>setMsg_Dstny(e.target.value)}
                        />
                </div>

                <button type='submit' className='login'>Enviar</button>

        </form>
    </div>
    );
};

// Exporta o arquivo
export default Mensagem;