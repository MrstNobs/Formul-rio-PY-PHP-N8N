import React from "react";
// Faz a importação de Bibliteca de rotas
import { Routes, Route } from 'react-router-dom';

// Importa arquivos componentes 
import Login from './login';
import Cadastro from './cadastro';
import Mensagem from './mensagem';
import Recuperar from "./recuperar";

const Rotas = () => {
    return(
        // Cria rotas para cada componente
        <Routes>
            <Route path="/" element={<Login />} />
            <Route path="/cadastro" element={<Cadastro />} />
            <Route path="/mensagem" element={<Mensagem />} />
            <Route path="/recuperar" element={<Recuperar />} />
        </Routes>
    );
};

// Exporta o arquivo
export default Rotas;