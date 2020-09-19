<?php

namespace Projet\Model;

function fetchOnce($request) {
    $request=$request->fetchAll();
    $request=$request[0][0];
    return $request;
}