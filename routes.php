<?php


const URL_LIST = [

    'GET' => [
        '/main' => [
            'controller' => 'General',
            'action' => 'main',
            'parameters' => []
        ],

        '/users/list' => [
            'controller' => 'User',
            'action' => 'list',
            'parameters' => []
        ],

        '/users/get' => [
            'controller' => 'User',
            'action' => 'get',
            'parameters' => ['id']
        ],

        '/users/update' => [
            'controller' => 'User',
            'action' => 'updateForm',
            'parameters' => []
        ],

        '/login' => [
            'controller' => 'User',
            'action' => 'loginForm',
            'parameters' => []
        ],

        '/logout' => [
            'controller' => 'User',
            'action' => 'logout',
            'parameters' => []
        ],

        '/reset_password' => [
            'controller' => 'User',
            'action' => 'resetPasswordRequestForm',
            'parameters' => []
        ],

        '/reset_password/form' => [
            'controller' => 'User',
            'action' => 'resetPasswordForm',
            'parameters' => ['id']
        ],

        '/user/search' => [
            'controller' => 'User',
            'action' => 'search',
            'parameters' => ['email']
        ],

        '/admin/users/list' => [
            'controller' => 'Admin',
            'action' => 'list',
            'parameters' => []
        ],

        '/admin/users/get' => [
            'controller' => 'Admin',
            'action' => 'get',
            'parameters' => ['id']
        ],

        '/admin/users/delete' => [
            'controller' => 'Admin',
            'action' => 'delete',
            'parameters' => ['id']
        ],

        '/admin/users/update' => [
            'controller' => 'Admin',
            'action' => 'updateForm',
            'parameters' => ['id']
        ],

        '/files/list' => [
            'controller' => 'File',
            'action' => 'listFiles',
            'parameters' => []
        ],

        '/files/get' => [
            'controller' => 'File',
            'action' => 'getFile',
            'parameters' => ['id']
        ],

        '/files/add' => [
            'controller' => 'File',
            'action' => 'addFileForm',
            'parameters' => []
        ],

        '/files/rename' => [
            'controller' => 'File',
            'action' => 'renameFileForm',
            'parameters' => ['id']
        ],

        '/files/remove' => [
            'controller' => 'File',
            'action' => 'removeFile',
            'parameters' => ['id']
        ],

        '/directories/add' => [
            'controller' => 'File',
            'action' => 'addDirForm',
            'parameters' => []
        ],

        '/directories/rename' => [
            'controller' => 'File',
            'action' => 'renameDirForm',
            'parameters' => ['id']
        ],

        '/directories/get' => [
            'controller' => 'File',
            'action' => 'getDirInfo',
            'parameters' => ['id']
        ],

        '/directories/delete' => [
            'controller' => 'File',
            'action' => 'removeDir',
            'parameters' => ['id']
        ],

        '/files/share' => [
            'controller' => 'File',
            'action' => 'shareList',
            'parameters' => ['id']
        ],

        '/files/share-add' => [
            'controller' => 'File',
            'action' => 'shareAdd',
            'parameters' => ['id', 'user_id']
        ],

        '/files/share-delete' => [
            'controller' => 'File',
            'action' => 'shareDelete',
            'parameters' => ['id', 'user_id']
        ]
    ],

    'POST' => [
        '/users/update' => [
            'controller' => 'User',
            'action' => 'update',   
            'parameters' => ['email', 'age']
        ],

        '/login' => [
            'controller' => 'User',
            'action' => 'login',
            'parameters' => ['email', 'password']
        ],

        '/reset_password' => [
            'controller' => 'User',
            'action' => 'resetPasswordLink',
            'parameters' => ['email']
        ],

        '/reset_password/form' => [
            'controller' => 'User',
            'action' => 'resetPasswordFormHandler',
            'parameters' => ['old_pass', 'new_pass', 'id']
        ],

        '/admin/users/update' => [
            'controller' => 'Admin',
            'action' => 'update',
            'parameters' => ['email', 'age', 'id']
        ],

        '/files/add' => [
            'controller' => 'File',
            'action' => 'addFile',
            'parameters' => ['id']
        ],
        '/files/rename' => [
            'controller' => 'File',
            'action' => 'renameFile',
            'parameters' => ['title', 'id']
        ],
        '/directories/add' => [
            'controller' => 'File',
            'action' => 'addDir',
            'parameters' => ['id', 'dirTitle']
        ],
        '/directories/rename' => [
            'controller' => 'File',
            'action' => 'renameDir',
            'parameters' => ['title', 'id', 'userId']
        ],
    ]
 ];