<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Comments extends BaseController
{
    /**
     * 
     * @return string
     */
    public function index()
    {
        $comment = model('CommentModel');
        $ansver = [
            'comments'=>$comment->getPage(
                    $this->request->getVar('page'),
                    $this->request->getVar('order')),
            'order'=>$this->request->getVar('order') ?
                $this->request->getVar('order') :
            1];
        if ($this->request->getVar('json') == 1) {
            return $this->response->setJSON($ansver);
            
        } else {
            return view('comments/index', $ansver);
        }
        
    }
        
    public function store() {
        $ansver = [];
        if (! $this->validate([
            'email' => "required|max_length[100]|valid_email",
            'text'  => "required",
        ])) {
            $ansver = [
                'email' => $this->request->getVar('email'),
                'text' => $this->request->getVar('text'),
                'errors' => $this->validator->getErrors(),
            ];
        } else {
            $inputData = [
                'email' => $this->request->getVar('email'),
                'text' => $this->request->getVar('text'),
            ];
            $comment = model('CommentModel');
            $comment->insert($inputData);
            $comment = $comment->getPage(
                    $this->request->getVar('page'),
                    $this->request->getVar('order'));
            $ansver = [ 'success'=> 1];
        }
        $ansver['csrf_token'] = csrf_hash();
        return $this->response->setJSON($ansver);
    }
    
    public function delete(int $id) {
        $comment = model('CommentModel');
        $comment->delete($id);
        $comments = $comment->getPage(
                    $this->request->getVar('page'),
                    $this->request->getVar('order'));
        $ansver = [
                'comments' => $comments,
                'pages' => $comments['pager']->getLastPage(),
            ];
        $ansver['csrf_token'] = csrf_hash();
        return $this->response->setJSON($ansver);
    }
}
