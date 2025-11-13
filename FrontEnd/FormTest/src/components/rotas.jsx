import React from "react";
import { Routes, Route } from 'react-router-dom';

import Login from './login';
import Cadastro from './cadastro';
import Mensagem from './mensagem';
import Recuperar from "./recuperar";

const Rotas = () => {
    return(
        <Routes>
            <Route path="/" element={<Login />} />
            <Route path="/cadastro" element={<Cadastro />} />
            <Route path="/mensagem" element={<Mensagem />} />
            <Route path="/recuperar" element={<Recuperar />} />
        </Routes>
    );
};

export default Rotas;