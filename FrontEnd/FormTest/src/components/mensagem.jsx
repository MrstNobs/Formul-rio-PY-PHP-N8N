import { useState } from "react";

const Mensagem = () => {
    const [email_dstny, setEmail_Dstny] = useState('');
    const [nome_dstny, setNome_Dstny] = useState('');
    const [msg_dstny, setMsg_Dstny] = useState('');

    const handleSubmit = async (e) => {
        e.preventDefault();

        const data = {email_dstny, nome_dstny, msg_dstny}

        try{
            const URL = import.meta.env.VITE_PY_MSG;
            const requisicao = await fetch(URL, {
                method: 'POST',
                headers: {'content-type': 'application/json'},
                body: JSON.stringify(data)
            });

            const resultado = await requisicao.json();
            if(resultado.success){
                alert(resultado.message);
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
                    >
                    </input>
                </div>

                <div className='inputBox'>
                    <input 
                        placeholder='Digite o nome da pessoa'
                        value={nome_dstny}
                        onChange={(e)=>setNome_Dstny(e.target.value)}
                        ></input>
                </div>

                <div className='inputBox'>
                    <input 
                        placeholder='Digite sua mensagem'
                        value={msg_dstny}
                        onChange={(e)=>setMsg_Dstny(e.target.value)}
                        ></input>
                </div>


                <button type='submit' className='login'>Enviar</button>

        </form>
    </div>
    );
};

export default Mensagem;