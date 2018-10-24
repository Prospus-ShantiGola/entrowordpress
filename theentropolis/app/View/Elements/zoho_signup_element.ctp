<!-- Note :
   - You can modify the font style and form style to suit your website. 
   - Code lines with comments ???Do not remove this code???  are required for the form to work properly, make sure that you do not remove these lines of code. 
   - The Mandatory check script can modified as to suit your business needs. 
   - It is important that you test the modified form before going live.


 -->
<?php   $new_site_url=  $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] ;?>
<div id='crmWebToEntityForm' style='width:100%;margin:auto;' class="footer-signup">
   <META HTTP-EQUIV ='content-type' CONTENT='text/html;charset=UTF-8'> 
<form action="https://crm.zoho.com/crm/WebToContactForm" name=WebToContacts1526579000000985005 method='POST' id= "WebToContactFormOn" onSubmit='javascript:document.charset="UTF-8"; return checkMandatory()' accept-charset='UTF-8' style="width:100%">

   <!-- Do not remove this code. -->
  <input type='text' style='display:none;' name='xnQsjsdp' value='21afbb9beb1b2002e6d6a460eb1495b5626168f994583a26d1704c092c00a794'/>
  <input type='hidden' name='zc_gad' id='zc_gad' value=''/>
  <input type='text' style='display:none;' name='xmIwtLD' value='a4af946fa5b5ee249d5de8071774b4229a7006cdb56f9d87f51db4c5fab46e72'/>
  <input type='text' style='display:none;'  name='actionType' value='Q29udGFjdHM='/>

<!--   <input type='text' style='display:none;' name='returnURL' value='http&#x3a;&#x2f;&#x2f;<?php echo $_SERVER['HTTP_HOST'] ;?>&#x2f;' />  -->
 <input type='text' style='display:none;' name='returnURL' value='http&#x3a;&#x2f;&#x2f;<?php echo $new_site_url;?>' />  
 <!--  <input type='text' style='display:none;' name='returnURL' value='http&#x3a;&#x2f;&#x2f;localhost\trepicity&#x2f;' />   -->

   <!-- Do not remove this code. -->
<style>
        tr,td{
          padding: 9px 0;
        }
        #crmWebToEntityForm{
          margin-top:2px !important;
        }
        #crmWebToEntityForm input{
          background: #464c58;
          border: solid 1px #7e9198;
          padding: 6px;
          color: #fff;
          font-size: 12px;
        }
        #crmWebToEntityForm .btnfilled.btnblue{
          padding:5px 12px;
        }
        .tp-social-link{
          margin: 5px 0 15px 0;
        }
        .col-2-input{
          width: 138px;
          position: relative;
          display: inline-block;
        }
        .col-2-input input{
            width: 100%;
        }
        .col-2-input:first-child{
          margin-right: 10px;
        }
        .col-1-input {
          display: inline-block;
          position: relative;
          width: 290px;
        }
        .col-1-input input{
            width: 100%;
        }
        span.error_msg {
          color: red;
          text-align: left;
          float: left;
          position: absolute;
          left: 0;
          top: 32px;
          font-weight: 300;
          font-size: 12px;
        }
        @media (max-width: 767px) {
          .footer-signup {
            justify-content: flex-start;
          }
        }
      </style>

       <table style="width:100%; margin-top:4px;">

          <tr>
            <td><!--<span class="error_msg"></span>-->
              <span class="col-2-input">
                <input class="signup_first_name" type='text' maxlength='40' name='First Name' Placeholder="First Name*"  />
              </span>
              <span class="col-2-input">
                <input class="signup_last_name" type='text' maxlength='80' name='Last Name' Placeholder="Last Name*"   />
              </span>
            </td>
          </tr>

          <tr> 
            <td>
              <span class="col-1-input"><input type='text' class="signup_email" maxlength='100' name='Email' Placeholder="Email Address*"  /></span>
            </td>
          </tr>

  
 <tr style='display:none;' >
            <td style=''>
    <select style='' name='Lead Source' class= "signup_lead_source">
      <option value='-None-'>None</option>
      <option value='Advertisement'>Advertisement</option>
      <option value='Chat'>Chat</option>
      <option value='Cold&#x20;Call'>Cold Call</option>
      <option value='Employee&#x20;Referral'>Employee Referral</option>
      <option value='External&#x20;Referral'>External Referral</option>
      <option value='Get&#x20;In&#x20;Touch'>Get In Touch</option>
      <option value='Kidpreneur&#x20;City&#x20;Subscriptions'>Kidpreneur City Subscriptions</option>
      <option selected value='Newsletter&#x20;Signup' >Newsletter Signup</option>
      <option value='Ninja&#x20;Pitch'>Ninja Pitch</option>
      <option value='Nominate&#x20;a&#x20;School'>Nominate a School</option>
      <option value='OnlineStore'>Online Store</option>
      <option value='Partner'>Partner</option>
      <option value='Public&#x20;Relations'>Public Relations</option>
      <option value='Register&#x20;your&#x20;Kidpreneur'>Register your Kidpreneur</option>
      <option value='Sales&#x20;Mail&#x20;Alias'>Sales Email Alias</option>
      <option value='Schools&#x20;Pitch&#x20;Competition'>Schools Pitch Competition</option>
      <option value='Schools&#x20;Program'>Schools Program</option>
      <option value='Seminar&#x20;Partner'>Seminar Partner</option>
      <option value='Seminar-Internal'>Internal Seminar</option>
      <option value='TEST&#x20;CONTACT'>TEST CONTACT</option>
       <option  value='TEST1'>TEST1</option>
      <option value='Trade&#x20;Show'>Trade Show</option>
      <option value='Web&#x20;Cases'>Web Cases</option>
      <option value='Web&#x20;Download'>Web Download</option>
      <option value='Web&#x20;Mail'>Web Mail</option>
      <option value='Web&#x20;Research'>Web Research</option>
    </select></td></tr>

<tr>
            <td>
   <input style='font-size:12px;color:#131307' type='submit' value='SIGN UP' class="btnfilled btnblue medWgt" />
  
      </td>
  </tr>
   </table>
  <script>
    var mndFileds=new Array('First Name','Last Name','Email');
    var fldLangVal=new Array('First Name','Last Name','Email Address');
    var name='';
    var email='';

    function checkMandatory() {
      $('.error_msg').remove();
      var error_count = 0;
    for(i=0;i<mndFileds.length;i++) {
      var fieldObj=document.forms['WebToContacts1526579000000985005'][mndFileds[i]];
      if(fieldObj) {
      if (((fieldObj.value).replace(/^\s+|\s+$/g, '')).length==0) {
       if(fieldObj.type =='file')
        { 
         alert('Please select a file to upload.'); 
         fieldObj.focus(); 
         return false;
        } 

        var html_val = '<span class="error_msg">Required field.</span>';
      $('input[name="'+mndFileds[i]+'"]').after(html_val);
     // alert(fldLangVal[i] +' cannot be empty.'); 
              fieldObj.focus();

        error_count= error_count+1;
      //  alert(error_count);
      }

       else if(fieldObj.name =='Email')
             {
         
               var email_valid =    emailPatternCheck(fieldObj.value);
              // alert(email_valid)
               if(email_valid==false)
               {
                //  alert('Please enter valid Email Address.'); 
                   $('input[name="Email"]').after("<span class='error_msg'>Please enter valid email address.</span>");
                  fieldObj.focus();
                   return false;
               }

               else if (error_count ==0)
               {

             
                 var  signup_first_name = $('.signup_first_name').val();
                var  signup_last_name = $('.signup_last_name').val();
                var  signup_email = $('.signup_email').val();
                var  signup_lead_source = $('.signup_lead_source').val();


                 jQuery.ajax({
                          type: 'POST',
                          url: '<?php echo $this->webroot ?>Pages/insertIntoPipeline/',
                          data: {'signup_first_name': signup_first_name,
                           'signup_last_name': signup_last_name,
                           'signup_email': signup_email,
                           'signup_lead_source': signup_lead_source,
                         },
                          success: function (data) {
                            //alert( data);
                            // if(error_count)
                            // {
                            //   return false;
                            // }
                            if(data =='true' )
                            {
                             $('#about-thanks-zoho').modal('show');
                              //var myData = $("#WebToContactFormOn").data('trigger'); 

                            }else
                            {
                                $('input[name="Email"]').after("<span class='error_msg'>Email address already exists.</span>");
                              
                                return false;
                            }
                          }
                        });
            return false;
               }
              
             }
       
       try {
           if(fieldObj.name == 'Last Name') {
        name = fieldObj.value;
          }
      } catch (e) {

      }
        }

    }  // for loop 

       // alert(error_count);
        if(error_count)
        {
          return false;

        }      

    
       }


    function emailPatternCheck(email) {
    var re = new RegExp(/^[a-zA-Z0-9\_\-\'\.\+]+\@[a-zA-Z0-9\-\_]+(?:\.[a-zA-Z0-9\-\_]+){0,3}\.(?:[a-zA-Z0-9\-\_]{2,15})$/);
    return re.test(email) ? !0 : !1
}   
     
</script>
  </form>
</div>
