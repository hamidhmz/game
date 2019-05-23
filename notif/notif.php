<?php
header_remove('x-powered-by');
if (isset($_GET['error'])) 
  {  
    if (($_GET['error'])=='900') 
    {
      echo "<script type='text/javascript'>";
      echo  "alert('این نام کاربری اشغال شده');";
      echo "</script>";  
    } 
    elseif (($_GET['error'])=='901') 
    {
      echo "<script type='text/javascript'>";
      echo  "alert('یکی از فیلد ها خالی است');";
      echo "</script>";  
    } 
    elseif (($_GET['error'])=='902') 
    {
      echo "<script type='text/javascript'>";
      echo  "alert('پسوورد ها تطبیق ندارد.');";
      echo "</script>";  
    } 
    elseif (($_GET['error'])=='903') 
    {
      echo "<script type='text/javascript'>";
      echo  "alert('نام کاربری یا رمز عبور را اشتباه وارد کردید.');";
      echo "</script>";  
    }
    elseif (($_GET['error'])=='904') 
    {
      echo "<script type='text/javascript'>";
      echo  "alert('خطایی در ثبت اطلاعات پیش آمده.');";
      echo "</script>";  
    }
    elseif (($_GET['error'])=='905') 
    {
      echo "<script type='text/javascript'>";
      echo  "alert('اطلاعات شما برای ورود به بازی کامل نیست..');";
      echo "</script>";  
    }
    elseif (($_GET['error'])=='906') 
    {
      echo "<script type='text/javascript'>";
      echo  "alert('چنین ایمیلی وجود ندارد.');";
      echo "</script>";  
    }
    elseif (($_GET['error'])=='907') 
    {
      echo "<script type='text/javascript'>";
      echo  "alert('چنین ایمیلی وجود دارد.');";
      echo "</script>";  
    }
    elseif (($_GET['error'])=='908') 
    {
      echo "<script type='text/javascript'>";
      echo  "alert('saved not in database your changes.');";
      echo "</script>";  
    }
    elseif (($_GET['error'])=='909') 
    {
      echo "<script type='text/javascript'>";
      echo  "alert('تغییرات ثبت نشد مشکلی پیش آمده!');";
      echo "</script>";  
    }
    elseif (($_GET['error'])=='910') 
    {
      echo "<script type='text/javascript'>";
      echo  "alert('فایل آپلود نشد!');";
      echo "</script>";  
    }
    elseif (($_GET['error'])=='911') 
    {
      echo "<script type='text/javascript'>";
      echo  "alert('نوع فایل مجاز نیست!');";
      echo "</script>";  
    }
    elseif (($_GET['error'])=='912') 
    {
      echo "<script type='text/javascript'>";
      echo  "alert('پسوورد ها یکی نیست نیست!');";
      echo "</script>";  
    }
    elseif (($_GET['error'])=='913') 
    {
      echo "<script type='text/javascript'>";
      echo  "alert('پسوورد وارد شده اشتباه است!');";
      echo "</script>";  
    }
    elseif (($_GET['error'])=='914') 
    {
      echo "<script type='text/javascript'>";
      echo  "alert('اکانت شما فعال نیست!');";
      echo "</script>";  
    }
    elseif (($_GET['error'])=='915') 
    {
      echo "<script type='text/javascript'>";
      echo  "alert('مقدار موجودی شما قابل برداشت نیست!');";
      echo "</script>";  
    }
    elseif (($_GET['error'])=='916') 
    {
      echo "<script type='text/javascript'>";
      echo  "alert('موجودی کمتر از مقدار درخواستی است!');";
      echo "</script>";  
    }
    elseif (($_GET['error'])=='917') 
    {
      echo "<script type='text/javascript'>";
      echo  "alert('ابتدا باید اطلاعات خود را کامل کنید!');";
      echo "</script>";  
    }
    elseif (($_GET['error'])=='918') 
    {
      echo "<script type='text/javascript'>";
      echo  "alert('ارور دیتا بیس!');";
      echo "</script>";  
    }
    elseif (($_GET['error'])=='919') 
    {
      echo "<script type='text/javascript'>";
      echo  "alert('خطایی پیش آمده!');";
      echo "</script>";  
    }
    elseif (($_GET['error'])=='920') 
    {
      echo "<script type='text/javascript'>";
      echo  "alert('پرداخت با خطا مواجه شد...شماره تراکنش:'".$_GET['catch'].");";
      echo "</script>";  
    }
    elseif (($_GET['error'])=='921') 
    {
      echo "<script type='text/javascript'>";
      echo  "alert('لطفا کپچا را پر کنید');";
      echo "</script>";  
    }
    elseif (($_GET['error'])=='922') 
    {
      echo "<script type='text/javascript'>";
      echo  "alert('عدم تایید شما!!!!');";
      echo "</script>";  
    }
    elseif (($_GET['error'])=='923') 
    {
      echo "<script type='text/javascript'>";
      echo  "alert('حساب کاربری شما مسدود شده!!!!');";
      echo "</script>";  
    }
    elseif (($_GET['error'])=='924') 
    {
      echo "<script type='text/javascript'>";
      echo  "alert('یمیل وارد شده معتبر نیست!!!!');";
      echo "</script>";  
    }
    elseif (($_GET['error'])=='925') 
    {
      echo "<script type='text/javascript'>";
      echo  "alert('کد داخل تصویر را صحیح وارد کنید.');";
      echo "</script>";  
    }
    elseif (($_GET['error'])=='926') 
    {
      echo "<script type='text/javascript'>";
      echo  "alert('پیام ارسال نشد!!!!');";
      echo "</script>";  
    }
    elseif (($_GET['error'])=='927') 
    {
      echo "<script type='text/javascript'>";
      echo  "alert('بدون قبول قوانین نمیتوانید ثبت نام کنید!!!!');";
      echo "</script>";  
    }
    elseif (($_GET['error'])=='928') 
    {
      echo "<script type='text/javascript'>";
      echo  "alert('عملیات موفق نبود بعدا سای کنید!!!!');";
      echo "</script>";  
    }
    elseif (($_GET['error'])=='929') 
    {
      echo "<script type='text/javascript'>";
      echo  "alert('ورود غیر مجاز!!!!');";
      echo "</script>";  
    }
    elseif (($_GET['error'])=='930') 
    {
      echo "<script type='text/javascript'>";
      echo  "alert('حداقل مبلق درخواستی 30000 تومان است!!!!');";
      echo "</script>";  
    }
    elseif (($_GET['error'])=='931') 
    {
      echo "<script type='text/javascript'>";
      echo  "alert('کاربر یافت نشد!!!!');";
      echo "</script>";  
    }
    elseif (($_GET['error'])=='932') 
    {
      echo "<script type='text/javascript'>";
      echo  "alert('شماره حساب وارد شده نا معتبر است.');";
      echo "</script>";  
    }
    elseif (($_GET['error'])=='933') 
    {
      echo "<script type='text/javascript'>";
      echo  "alert('شماره شبا وارد شده نا معتبر است.');";
      echo "</script>";  
    }
    elseif (($_GET['error'])=='934') 
    {
      echo "<script type='text/javascript'>";
      echo  "alert('این کاربر قبلا ثبت نام کرده.');";
      echo "</script>";  
    }
    elseif (($_GET['error'])=='935') 
    {
      echo "<script type='text/javascript'>";
      echo  "alert('شما یک پردازش در صف دارید.');";
      echo "</script>";  
    }
    elseif (($_GET['error'])=='936')
    {
        echo "<script type='text/javascript'>";
        echo  "alert('لطفا اطلاعات را به لاتین وارد کنید.');";
        echo "</script>";
    }
    elseif (($_GET['error'])=='937')
    {
        echo "<script type='text/javascript'>";
        echo  "alert('رمز عبور باید کمتر از ۱۴ کاراکتر باشد.');";
        echo "</script>";
    }
    elseif (($_GET['error'])=='938')
    {
        echo "<script type='text/javascript'>";
        echo  "alert('رمز عبور باید بیشتر از ۶ کاراکتر باشد.');";
        echo "</script>";
    }
    elseif (($_GET['error'])=='939')
    {
        echo "<script type='text/javascript'>";
        echo  "alert('نام کاربری باید کمتر از ۱۴ کاراکتر باشد.');";
        echo "</script>";
    }
    elseif (($_GET['error'])=='940')
    {
        echo "<script type='text/javascript'>";
        echo  "alert('نام کاربری باید بیشتر از ۶ کاراکتر باشد.');";
        echo "</script>";
    }
    elseif (($_GET['error'])=='941')
    {
        echo "<script type='text/javascript'>";
        echo  "alert(' باید کمتر از ۱۴ کاراکتر باشد FullName ');";
        echo "</script>";
    }
    elseif (($_GET['error'])=='942')
    {
        echo "<script type='text/javascript'>";
        echo  "alert('FullName باید بیشتر از ۶ کاراکتر باشد.');";
        echo "</script>";
    }




  }
  if (isset($_GET['tip'])) 
  {  
    if (($_GET['tip'])=='800') 
    {
      echo "<script type='text/javascript'>";
      echo  "alert('شما با موفقیت وارد شدید');";
      echo "</script>";  
    }
    elseif (($_GET['tip'])=='801') 
    {
      echo "<script type='text/javascript'>";
      echo  "alert('ثبت نام و ورود با موفقیت انجام شد.');";
      echo "</script>";  
    }
    elseif (($_GET['tip'])=='802') 
    {
      echo "<script type='text/javascript'>";
      echo  "alert('پیام ارسال شد.');";
      echo "</script>";
    }
    elseif (($_GET['tip'])=='803') 
    {
      echo "<script type='text/javascript'>";
      echo  "alert('شما با موفقیت خارج شدید.');";
      echo "</script>";  
    }
    elseif (($_GET['tip'])=='804') 
    {
      echo "<script type='text/javascript'>";
      echo  "alert('پسوورد با موفقیت ارسال شد.');";
      echo "</script>";  
    }
    elseif (($_GET['tip'])=='805') 
    {
      echo "<script type='text/javascript'>";
      echo  "alert('تغییرات با موفقیت ثبت شد اکانت شما فعال شد.');";
      echo "</script>";  
    }
    elseif (($_GET['tip'])=='806') 
    {
      echo "<script type='text/javascript'>";
      echo  "alert('تغییرات با موفقیت ثبت شد.');";
      echo "</script>";  
    }
    elseif (($_GET['tip'])=='807') 
    {
      echo "<script type='text/javascript'>";
      echo  "alert('عکس شما موفقیت ثبت شد.');";
      echo "</script>";  
    }
    elseif (($_GET['tip'])=='808') 
    {
      echo "<script type='text/javascript'>";
      echo  "alert('درخواست شما ثبت شد.');";
      echo "</script>";  
    }
    elseif (($_GET['tip'])=='809') 
    {
      echo "<script type='text/javascript'>";
      echo  "alert('کاربر غیر فعال شد.');";
      echo "</script>";  
    }
    elseif (($_GET['tip'])=='810') 
    {
      echo "<script type='text/javascript'>";
      echo  "alert('پرداخت با موفقیت انجام شد.');";
      echo "</script>";  
    }
    elseif (($_GET['tip'])=='811') 
    {
      echo "<script type='text/javascript'>";
      echo  "alert('پیام حذف شد.');";
      echo "</script>";  
    }
    elseif (($_GET['tip'])=='812') 
    {
      echo "<script type='text/javascript'>";
      echo  "alert('کاربر فعال شد.');";
      echo "</script>";  
    }
    elseif (($_GET['tip'])=='813') 
    {
      echo "<script type='text/javascript'>";
      echo  "alert('کاربر حذف شد.');";
      echo "</script>";  
    }
    elseif (($_GET['tip'])=='814') 
    {
      echo "<script type='text/javascript'>";
      echo  "alert('اطلاعات با موفقیت ثبت شد.');";
      echo "</script>";  
    } elseif (($_GET['tip']) == '815') {
        echo "<script type='text/javascript'>";
        echo "alert('درخواست شما حذف شد.');";
        echo "</script>";
    }
    elseif (($_GET['tip'])=='816')
    {
        echo "<script type='text/javascript'>";
        echo  "alert('انجام شد.');";
        echo "</script>";
    }
  }