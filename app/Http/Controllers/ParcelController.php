<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

use PrintNode\Credentials;
use PrintNode\PrintJob;
use PrintNode\Request as PrintRequest;
use TCPDF;

use App\Parcel;
use App\User;

class ParcelController extends Controller
{
    /*
        Check prihibited items
    */
    public function checkProhibited()
    {
        return view('prohibitions/check');
    }

    /*
        Check tracking number
    */
    public function checkTracking(Request $request)
    {
        $trackNumber = trim($request->input('tracking'));
        $countTrackNumber =  Parcel::where('track', $trackNumber)->count();
        if ($countTrackNumber == 1) {
              return redirect('/register_prohibited/'.$trackNumber);
        }
        else {
            $request->session()->flash('message.level', "danger");
            $request->session()->flash('message.content', "Данный идентификатор не найден!");

            return back()->withInput();
        }
    }

    /*
        Registration prihibited items
    */
    public function registerProhibited($trackNumber)
    {
        try {
            $parcel = Parcel::where('track', $trackNumber)->get()->first();
            $user = $parcel->user()->get()->first();

            return view('prohibitions/registration', ['parcel' => $parcel, 'user'=>$user]);
        } catch (Exception $e) {

        }
    }
    /*
        Save prohibited items
    */

    public function registerProhibitedForm(Request $request)
    {

        // Registration data
        $inputData = $request->only('user', 'weight', 'parcel');
        $firstLetterParcel = $inputData['parcel'][0];
        $parcel = new Parcel();
        $parcel->user_id = $inputData['user'];
        $parcel->weight = $inputData['weight'];
        $parcel->track = "N/a";
        $parcel->shop = "See detail parcel";
        // Проверяем тип посылки и на основе этого формируем комментарий

        if ($firstLetterParcel == 'e') {
            $parcel->comment ='1-й тип комментария';
        }
        else if ($firstLetterParcel == 's') {
            $parcel->comment ='2-й тип комментария';
        }

        $availExt = ['jpg', 'jpeg', 'png', 'bmp'];

        if($request->hasFile('image')){
            $image = $request->file('image');
            if (array_search(strtolower($image->getClientOriginalExtension()), $availExt) === false) {
                return back()->withInput();
            }

           // Новое имя файла
            $engName = $this->translit(preg_replace('/\..+$/', '', $image->getClientOriginalName()));
            $imageName = $engName.'.'.$image->getClientOriginalExtension();
            $path = $image->move('img/prohibited_items', $imageName);
            // Сохраняем изображение
            $parcel->img = 'img/prohibited_items/'.$imageName;
        }
        $parcel->save();

        // Send email
        $user = User::find($inputData['user'])->toArray();
        $userEmail = $user['email'];
        $data = array();

       Mail::send('email.registration', $data, function ($message) use ($userEmail) {

            $message->from('viking060794@gmail.com', 'WeShip2You - Registration items');

            $message->to($userEmail)->subject('Learning Laravel test email');

        });

        
        $dateNow = date('dym');
        $ident = rand(1000, 9999);
        $NumParcel = $dateNow.'-'.$ident;

        // Generate pdf
        $userFullName = $this->translit($user['name'].' '.$user['surname']);

        $pdf = new TCPDF('P', 'mm', 'A6', true, 'UTF-8', false);

        $pdf->setPrintHeader(false); 
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(10, 10, 10);
        $pdf->AddPage();


        $pdf->SetXY(3, 5);
        $pdf->Cell(30, 6, 'User id:'.$inputData['user'] , 0, 0, 'C');

        $pdf->SetXY(5, 10);
        $pdf->Cell(30, 6, $userFullName, 0, 0, 'C'); 

        $pdf->SetXY(23, 15);
        $pdf->Cell(30, 6, 'Number parcel: p'.$NumParcel, 0, 0, 'C');

        $style = array(
            'position' => '',
            'align' => 'C',
            'stretch' => false,
            'fitwidth' => true,
            'cellfitalign' => '',
            'border' => true,
            'hpadding' => 'auto',
            'vpadding' => 'auto',
            'fgcolor' => array(0,0,0),
            'bgcolor' => false, //array(255,255,255),
            'text' => false,
            'font' => 'helvetica',
            'fontsize' => 8,
            'stretchtext' => 4
        );

        $pdf->SetXY(5, 25);
        $pdf->write1DBarcode($NumParcel, 'CODE11', '', '', '', 18, 0.5, $style, 'N'); 

        $pdf->SetXY(23, 45);
        $pdf->Cell(30, 6, 'ID partner: 1', 0, 0, 'C');
        

        $nameFile = uniqid();
        $pdf->Output(__DIR__.'/pdf/'.$nameFile.'.pdf', 'F');
        $tmp = ini_get('upload_tmp_dir');

        // Print sticker
        $credentials = new Credentials();
        $credentials->setApiKey('b8cd6a89f815f25bbae1c61aa88acf0dc0013e0f');

        $requestPrint = new PrintRequest($credentials);

        $computers = $requestPrint->getComputers();
        $printers = $requestPrint->getPrinters();
        $printJobs = $requestPrint->getPrintJobs();

        $printJob = new PrintJob();

        $printJob->printer = $printers[3];
        $printJob->contentType = 'pdf_base64';
        $printJob->content = base64_encode(file_get_contents(__DIR__.'/pdf/'.$nameFile.'.pdf'));
        $printJob->source = 'WeShip2You';
        $printJob->title = $userFullName.$dateNow;

        $responsePrint = $requestPrint->post($printJob);
        $statusCode = $responsePrint->getStatusCode();
        $statusMessage = $responsePrint->getStatusMessage();

        $headers = $responsePrint->getHeaders();
        $content = $responsePrint->getContent();

        return redirect('/');

    }

    public function translit($str) {
        $rus = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
        $lat = array('A', 'B', 'V', 'G', 'D', 'E', 'E', 'Zh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'Kh', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', '', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'zh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'kh', 'c', 'ch', 'sh', 'sch', 'y', 'y', '', 'e', 'yu', 'ya');
        return str_replace($rus, $lat, $str);
    }

}
