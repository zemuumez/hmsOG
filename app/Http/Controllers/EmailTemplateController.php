<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Flash;
class EmailTemplateController extends AppBaseController
{
    public function index(){
        return view('email-template.index');
    }

    public function edit($id)
    {
        $template = EmailTemplate::findOrFail($id);

        return view('email-template.edit', compact('template'));
    }

    public function update(Request $request, $id)
    {
        $template = EmailTemplate::findOrFail($id);
        $request->validate([
            'email_subject' => 'required',
            'email_content' => 'required',
        ]);
        $template->update([
            'email_subject' => $request->email_subject,
            'email_content' => $request->email_content,
        ]);
        Flash::success(__('messages.email_template.email_template_saved_successfully'));

        return redirect()->route('email-template.index');
    }
}
