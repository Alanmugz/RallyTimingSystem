#
#    Copy items from C:\xampp\htdocs\TimingSystem to C:\Users\soundstore1\Desktop\Rally_Timing_System
#

Write-Debug 'Beginnig Transfer......'

#Files
Copy-Item C:\xampp\htdocs\TimingSystem\connection.php C:\Users\soundstore1\Desktop\Rally_Timing_System\Website
Copy-Item C:\xampp\htdocs\TimingSystem\custom_comparision.php C:\Users\soundstore1\Desktop\Rally_Timing_System\Website
Copy-Item C:\xampp\htdocs\TimingSystem\entrant.php C:\Users\soundstore1\Desktop\Rally_Timing_System\Website
Copy-Item C:\xampp\htdocs\TimingSystem\entrantinfo.php C:\Users\soundstore1\Desktop\Rally_Timing_System\Website
Copy-Item C:\xampp\htdocs\TimingSystem\entrylist.php C:\Users\soundstore1\Desktop\Rally_Timing_System\Website
Copy-Item C:\xampp\htdocs\TimingSystem\event.php C:\Users\soundstore1\Desktop\Rally_Timing_System\Website
Copy-Item C:\xampp\htdocs\TimingSystem\event_individual.php C:\Users\soundstore1\Desktop\Rally_Timing_System\Website
Copy-Item C:\xampp\htdocs\TimingSystem\functions.php C:\Users\soundstore1\Desktop\Rally_Timing_System\Website
Copy-Item C:\xampp\htdocs\TimingSystem\index.php C:\Users\soundstore1\Desktop\Rally_Timing_System\Website
Copy-Item C:\xampp\htdocs\TimingSystem\results.php C:\Users\soundstore1\Desktop\Rally_Timing_System\Website
Copy-Item C:\xampp\htdocs\TimingSystem\timeanddistance.php C:\Users\soundstore1\Desktop\Rally_Timing_System\Website

#Folders
Copy-Item C:\xampp\htdocs\TimingSystem\css C:\Users\soundstore1\Desktop\Rally_Timing_System\Website -Force
Copy-Item C:\xampp\htdocs\TimingSystem\icons C:\Users\soundstore1\Desktop\Rally_Timing_System\Website -Force
Copy-Item C:\xampp\htdocs\TimingSystem\images C:\Users\soundstore1\Desktop\Rally_Timing_System\Website -Force
Copy-Item C:\xampp\htdocs\TimingSystem\include C:\Users\soundstore1\Desktop\Rally_Timing_System\Website -Force
Copy-Item C:\xampp\htdocs\TimingSystem\logos C:\Users\soundstore1\Desktop\Rally_Timing_System\Website -Force

Write-Debug 'Transfer Complete'