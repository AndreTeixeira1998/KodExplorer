KodExplorer (http://kalcaddle.com/)
========
  KodExplorer is an open source Web-based online document management , code editor. It provides a kind of classic windows user interface , a set of online document management , file preview , edit, upload and download , unzip online music playback. Allows you to achieve web development directly in the browser , to preview the source files , website deployment. And also has local operations as easy , fast and safe experience.
 ` Business Edition license, please contact : kalcaddle # qq.com`
 
1. What is #### :
 - KodExplorer the sails studio developed a network file server management program .
 - A perfect replacement for FTP management : file server can be used to manage , zip unzip , backup and restore
- Support for common file preview : Support pictures, music, video preview , office, pdf format online preview.
 - Upload : Upload file fragmentation ; ensure the overall experience and large file uploading issues . Drag the folder to upload ...... .
 - Easily download : you can download directly to a folder directly downloaded marquee
 - Sharing : You can put your documents or folders directly share it for others to view or download
 - Online Programming: supports almost all programming languages ​​online editing ( Highlight , more comparable to native editing cursor sublime); automatic display function list
 - Excellent operating experience : Its convenient shortcut support , so you have a localized experience
 - Chinese and other multi- language support : Chinese fully compatible encoding , file editing automatic adaptation .
 - Ultra-fast speed : full use of Ajax + Json data communication , millisecond response speed ;
 - Full Platform Compatibility : Win Linux Mac (Apache, Nginx, IIS)

#### 2. usage scenarios :
 - Replace FTP, server , client software, and other complex installation and configuration . kod can use a key to install everywhere .
 - You can use it to manage your server ( backup , online decompression , release .... )
 - You can put him as a management linux operating system interface
 - Can be used as a private cloud storage systems, store your files ...
 - Of course, you can also be used to share files
 - Web IDE
 - More scenes waiting for you to dig ! ......
#### 3. Instructions
    Default added three users ( corresponding to different groups of users )
    Administrator : admin / admin
    Average user : demo / demo
    Guest User : guest / guest

    [ How to use ] download, unzip uploaded to your server path , data directory set 777 permissions. Ultra- convenient service access experience it !
    ( To ensure data security , it is best to configure the server does not allow directory listing )
    [ About uploading issue ] program does not do any restrictions, if need to upload large files , modify
php.ini: `upload_max_filesize = 1000M post_max_size = 1000M` [ Details : http: //955.cc/R2yT]
      Note that not more than 2g, otherwise it may result in php not function properly ( does not support post).
    [ About decompression problems ] program without any restrictions , if they fail set php memory limit. memory_limit 1000M
    [ About decompression garbled ] linux server compression , distortion will be downloaded to the Chinese under the windows. Because the system is the result . So try not to cross-system operation.
    [ On the " system error" ] configure php error level error_reporting; configuration php.ini error_reporting function or allow
    [ About compatibility ] recommend using chrome firefox ie9 + experience more complete . ie8 basically not compatible with the following process . chrome support folder drag and drop uploading.
    [ Open File ] office online file preview function, the server must be public ( external access to the server) ;
LAN requires the use of internal or refer to qq group shared "web office building " , and then configure kod program config / config.php OFFICE_SERVER
    [ Safety Tips ] To ensure data security , set the http server does not allow directory listing . [ Details : http: //955.cc/R2vw]
    [ Forgot your password ] modify data / system / member.php plaintext password md5 value , for example, will reset the password admin admin
        Then modify the first line : "name": "admin", "password": "21232f297a57a5a743894a0e4a801fc3"

    [ ] In addition to drag and drop files to upload most browsers support ie8 below ; recommend using chrome, 360, cheetah , uc , etc.
    [ ] In addition to the folder drag and drop uploading ie10 less , firefox most browsers are supported, it is recommended to use chrome, 360, cheetah , uc , etc.
    
![](https://cloud.githubusercontent.com/assets/3761968/2583304/764f562a-b9cf-11e3-8e59-afdbdffc20eb.png)

## editor
![](https://cloud.githubusercontent.com/assets/3761968/2583309/7fd52f8a-b9cf-11e3-8052-b4f908fd5209.png)


## player
![](https://cloud.githubusercontent.com/assets/3761968/2583312/84462bf0-b9cf-11e3-8b00-96fb3fc1610e.png)

## desktop
![](https://cloud.githubusercontent.com/assets/3761968/2583348/1b260572-b9d0-11e3-8f3e-3004dbbc63c9.png)


#### *Security :
#####This Application has been fixed and secured by Ben Khlifa Fahmi (https://www.benkhlifa.com/) , From the Tunisian Whitehats Security Team.
