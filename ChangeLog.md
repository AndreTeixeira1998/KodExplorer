### Ver3.2 `2015/10 / 25`
-----
#### Update:
 - Editor function list matching optimization; highly optimized bottom
 - Folder attributes: File Download: Download a temporary address [Download permanent, temporary Download]
 - Extension restrictions optimization
 - Prevent Violence request
 - Remote download optimized to generate only a temporary file; download interface turns off automatically stop
 - Editor refresh function
 - Office support custom preview
 - Right menu optimization: under the loose button on the menu since the corresponding action is triggered (refer to right-click menu mac Processing)
 - Mobile terminal adapter
     - 1. List Directory
     - 2 phone, open the page when the pad, to enter the mobile phone version
     - 3. Processing menu
     - 4. File Open Preview Processing

#### Fix bug
 - Remote download windows, rename failures
 - Automatic update failures
 - Chinese editor cursor corruption problem
 - Fixed https access
 - Ie8 landing page white background issues; (no background image); desktop background image scaling problems
 - Ie download a file, the file urlencode Chinese problem (windows-- server; browser --ie)
 - Non-admin file attributes trash; path Hide
 - Modify folder permissions bug
 - Create a shortcut file does not open repair
 - I share - pictures do not show
 - Window create txt (GB2312) - After uploading content to write utf8 open - open url garbled after sharing
 - Empty the upload list (not empty error failure)
 - Change passwords, add users ...... data directory does not have write permission error message
 - Ie8 9 Upload failures
 - Select the Firefox problem
 - Context Menu column line leading to the disappearance of the context menu
 - Sharing remove jiathis
 - Editor new directory tree on the left side issue
 - Rename textarea box is too big problem
 - Contents Sharing: with music files, double-click will open the secondary data, making it impossible to play
 - Close the video player issue


### Ver3.12 `2015/3 / 31`
-----
#### Update:
 - Compatible ie Chinese, resulting menu to save loss problem

### Ver3.11 `2015/3 / 30`
-----
#### Update:
 - The user does not have permission, optimization tips
 - User configuration data is saved, write fails tips

#### Fix bug
 - Share mp3, music playback path problem
 - Firefox bug fixes
 - Share page folder; office preview issue
 - editor
     Chinese cursor dislocation problem
     tab width based on the number of tags automatic scaling (ie Firefox incompatibilities)
     Corresponding to the current file path to title;
     Toolbar Firefox compatibility bug


### Ver3.1 `2015/3 / 26`
-----
#### Update:
 - Sharing can modify the path; after moving the original file share path to avoid failures
 - Automatically refresh share in the current directory; with the new configuration data
 - File Manager can not write the current folder, right-click menu function corresponding to the shield

#### Fix bug
 - Cookie automatic login fails, resulting in the loss of page css issue
 - Cookie path leading to the language setting failures
 - Application Center css loss problem
 - Can not unpack, verify permissions problem too restrictive
 - Directory tree on the left bottom is covered issue
 - Share office can not preview issue
 - User Groups; user group list selection error
 - Part of the Menu Editor Chinese garbled
 - Optimization of image preview

### Ver3.0 `2015/3 / 23`
-----
#### Update:
 - Document sharing [file, folder sharing; supports adding passwords; file sharing to support a variety of formats Online Preview]
 - Recycle Bin; (to avoid accidentally deleted)
 - System settings (custom program some configurations)
 - Head menu management
 - Download folder, batch download multiple choice
 - Comprehensive data security optimization
 - Upload Optimization:
     - Fragmentation upload, php.ini no longer subject to environmental constraints;
     - Add upload speed
     - Upload directory: With the current directory changes.
     - Upload completed clickable, enter the directory where the file
     - Simplified interface (not display switches to the current directory; do not save path, the list does not automatically deleted; do not need to maximize, and resize the window)
     - Post; overall status - into the title bar
     - Try to upload a large file fragmentation (treatment failures)
     - Upload folder: do not refresh f5 - Last Update
     - Display file name, size;
     - Allow duplicate file upload
     - Can be deleted before uploading
     - Optimization into the map display: displays the file size, speed, progress toward completion
 - editor:
     - Editor function list; c9 IDE; display and positioning; real-time updates: php function, js: function
     - List of functions on and off configuration
     - Php automatic code completion key part missing
     - The drop-down list; click anywhere else disappears
     - Non-txt is open; can not open the tips bindary: fla ...; the right to join: Forced edit
     - Font Optimization
     - Repair github relating to the cursor position dislocation problem (select, edit will appear)
 - Offline Download Optimization: Join cancellation mechanism; avoid sustained implementation; display the file size, speed, progress toward completion
 - Image cache according to the cache file MD5; nothing to do with the path
 - The list of files, hover the title display more detailed information
 - Dialog title bar right Joined: refresh, a new window opens
 - Maximize the dialog box, double-click, Unmaximize (only valid zoom dialog)
 - Maximize the dialog box, the dialog box is minimized zoom button icons change
 - Permission validation front (front-end uploading upload format restrictions); front-end detection - New, upload, delete
 - Set the center - - non-administrator user management display optimization
 - Public js part of dynamic invocation; subsequent optimization by js complete front-end MVC
 - Files, folders, create a shortcut
 - Folder Creation Project
 - Unknown file open prompt, do not automatically download
 - Context Menu: Add a shortcut to open letter
 - Right-adaptive: Hidden - -zip - video; multi-choice: only contains video and audio files are displayed - added playlist
 - Right to trigger the menu (temporarily modify jquery-contentMenu shield right button to move the trigger menu function)
 - Drag Optimization: marquee, tasktap switch; select the other text issues; performance issues
 - Marquee file, scroll beyond the custom screen is selected; shield text can be selected issues
 - Simple theme, the interface UI optimization
 - Seajs text: tpl modify html;
 - Unified walking proxy; hide the true address; web_root, web_host,
 - Unified proxy, office open permissions problem-solving: the encryption method to generate a temporary access address
 - The player supports more formats: wmv, avi, mpg, etc.

#### Fix bug and optimization:
 - Win path leads to the next question Chinese treatment
 - Public issue in drag copy and paste problem
 - Desktop Taskbar, right-click menu binding loss problem
 - Dialog title bar right-click menu does not display Problem
 - User name support Chinese
 - The password contains special characters bug treatment
 - The first player to solve the problem of open and sometimes can not be played.
 - New desktop where the problem; the new list of problems in different situations. Always on the last
 - Firefox mac compatibility compatibility; ie9 10 compatibility;
 - Appstore create, repair only allows the administrator to operate, display optimization
 - App created when js code type, single quotation marks cause problems unavailable.
 - Cycle Jump session judge if (isset ($ _ SESSION)!) {Session_start ();}
 - Chinese extension lead to get the win directory listing issues: extensions Get Optimization
 - Editor save ajax asynchronous request. loading
 - Upload directory error problem; (uploaded to another directory ie8 Chinese)
 - Optimization gd library support under mac
 - Drag the window to below the task, get out of the problem. top is greater than a certain value is locked
 - With multiple domain names; log out interfering
 - Office change https://view.officeapps.live.com/op/view.aspx?src=
 - Appstore icon mode; the default reduction;
 - List mode: Rename oexe modified but not automatically added; (oexe not shown)
 - A non-administrator, zip compression causes the file name is truncated fixes; win-win Chinese decompression processing; mac-mac Chinese decompression process
 - Download BOM have problems
 - Wwwroot identify the problem;

#### Fix bug 3.01 beta1:
 - New User drop-down menu to get out problem
 - Sharing bug
 - Set Center: Open tourists ui compatibility issues
 - Demo user office closed download preview ---- --- tips
 - File context menu: zip and replace the browser opens
 - Public directory public does not show
 - Open after sharing a mistake; not click on the Generate button
 - Enabled by default download rights
 - Shared by prohibiting the download; download ----
 - Log in bottom of the page copyright Hide
 - Management directory title bar shows the name of the corresponding folder
 - The root of the parent is prompted to continue
 - No download access; front-end verification
 - Check permissions occur after open repair of sharing failures
 - Share a common directory; directory tree click on the corresponding file list display issue
 - Share page cookie storage configuration issues
 - Share page: Download file preview authority with more authority
 - Modify front cover when you share a shared problem



### Ver2.8 `2014/11 / 23`
-----
#### Update:
 - Upload Control Optimization
 - Compatibility optimization; support ie8 more
 - The latest version of the update to the font-awesome
#### Fix bug:
 - Security Optimization
 - Picture upload large file compression options canceled
 - Optimization of the display part of the operation at issue


### Ver2.73 `2014/9 / 17`
#### Fix bug:
 - Optimization of security patches


### Ver2.72 `2014/9 / 16`
#### Fix bug: (bug solving and process optimization)
 - Arbitrary execution: remotely download apache spread vulnerabilities: determine whether it contains the extension .php.
 - Non-existent user
 - Desktop: Start button is covered tab
 - Theme switching dislocation problem
 - Transparent dialog dragging the title bar does not display problems

### Ver2.71 `2014/8 / 31`
-----
#### Update:
 - Save Configuration Editor: Font size, style theme; theme modification
 - Streamlining the initial desktop applications

#### Fix bug: (bug solving and process optimization)
 - Failed to modify user password:
 - Open the Settings to set the wallpaper, turn off, then open the individual centers, desktop mess
 - Desktop Start menu maximization problem
 - Language selection drop-down menu dislocation
 - Modify themes overlap
 - Appstore but not add application tips


### Ver2.7 `2014/8 / 25`
-----
#### Update:
 - Safety and Performance Optimization
 Do not cache static files added version identifier, an updated version of -?
 - Webuploader upgrade to 0.14 part of the optimization problem uploading
 - Error level: error_reporting (E_ERROR | E_WARNING);
 - The address bar (tab mode, edit mode) modes width adaptive
 - Self-built office resolution server configuration
 - Maximize fullscreen

#### Fix bug: (bug solving and process optimization)
 - Install added iconv, mbstring detection
 - Right rename shortcuts bubble up
 - Files picture thumbnail drag problem
 - Title excess interception Optimization
 - Editor preview scrollbar adaptive



### Ver2.61 `2014/7 / 12`
-----
#### Update:
 - Real-time search, search box varies depending on the content in real time to match the selected results;
 - Pop-up search box to traverse subfolders recursively search
 - Session key is added kod_ prefix to avoid conflicts with other key systems
 - Optimization of the mouse to select the editor window to the outside event processing

#### Fix bug: (bug solving and process optimization)
 - Backspace Back intercept browser events, access the folder as a former retreat of a document;
 - Search initials mismatch
 - Pop-pop-layer close layer, the parent window loses focus.
 - Code grunt split off part of the code, put it outside the program; submit to git, osc
 - Desktop: Delete key to delete the alert enter the shortcut
 - Install detection join skipped (only determine functions used) added multi-language
 - Zip compression do not have permission prompt red, false unified look
 - After a successful login verification code wrong Clear
 - Non-root users to drag and drop folders problem
 - Non-root decompression problem can not be decompressed
 - List oexe icon problem
 - Analyzing user directory does not exist
 - FileCahe mutex not reset
 - Ie 8 ~ 10 styles adjustment problems


### Ver2.6 `2014/7 / 6`
-----
#### Update:
 - Complete optimization; join strict verification mechanism
 - First run environmental monitoring [data directory detection function must support alerts]
 - Upload process already exists - create a copy (paste additionally includes decompression)
 - Select the optimization ctrl drag selected
 - Keyboard shortcuts to select files, multiple character support
 - Modify folder permissions (right - Property, you can modify)
 - Dialog added ico, corresponding to the taskbar
 - Right part of the menu and other performance optimizations
 - Remote download progress bar was added, the download speed and other information

#### Fix bug: (bug solving and process optimization)
 - Before downloading Analyzing the current directory writable
 - The file extension process is divided into user mode and extension mode permissions
 - Upload End Tip: success, failure reason
 - Upload extension restrictions solve apache .php * as the executing php bug.
 - Illegal filename characters defined <script>
 - Expand the directory tree arrow repair status
 - New file directory tree, no child nodes refresh bug solved
 - File size 0 can not upload problem
 - Under certain system folder windows into the infinite loop bug solved
 - Tips centered
 - Select the Taskbar tab problem: as has been shown, and click on the intersection of the window - hide; otherwise - displayed, and set the focus window
 - Drag url --oexe new window opens
 - Select the file, move to the visible area of ​​the screen (to solve the scroll bar up and down to select the file inconsistency)


### Ver2.51 `2014/6 / 22`
-----
#### Fix bug: (bug solving and process optimization)

 - Log repeatedly enter the wrong password verification code bug solved
 - Bug fixes: Creates a copy of added access control. And drag the file permissions consistent drag
 - File upload failed detection
 - Tree directory synchronization optimization


### Ver2.5 `2014/6 / 15`
-----
#### Update:
 - Increase drag to create a copy function can hold down ctrl, the current can be to a folder.
 - Multi-select drag optimization: cut to move to a folder
 - Creates a copy function
 - Tree of directories and files kept updated list of consistency mutual notification

#### Fix bug: (bug solving and process optimization)
 - Desktop Rename bug
 - Unified Dialog section bug
 - Php notice tips to resolve
 Back then json ajax returns non-display service error -
 - All entries are added index.php to solve part of the server is no default entry problem

### Ver2.4 `2014/6 / 8`
#### Update:
 - language selection
 - Remote download filename optimization
 - Optimization event directory tree
 - Favorites Click undefined
 - Did not have permission to create folder error message in red
 - Open the dialog does not show the problem. After the first show to open
 - Ajax error system error dialog box prompts content
 - Lazy loading optimization


### Ver2.3 `2014/6 / 2`
-----
#### Update:
 - Drag url-- create ext app
 - After the file management, directory tree changes (additions and deletions) automatically sync to the file list
 - After the file management, file list changes (additions and deletions) to automatically synchronize the directory tree
 - Chinese Username restrictions
 - Close the dialog box opens Anime
 - Other multiple optimization

#### Fix bug: (bug solving and process optimization)
 - Filename restrictions bug
 - Directory with multiple programs cookie bug fixes
 - Finally, the address bar display width problem
 - Under the server Path Editor to repair 404 Preview
 - Directory tree display optimization
 - Remember Password login Optimization

### Ver2.2 `2014/5 / 11`
-----
#### Update:
 - Public directory support (multiple users can share the directory, write privileges follow the user group permissions)
 - Automatic optimization upgrade
 - Increase file management toolbar menu of options to operate the mobile device
 - File editor, file directory tree and down to switch keyboard shortcuts added
 - Remove the directory tree database to modify personal directory, such as multiple copy
 - Open the default user directory

#### Fix bug: (bug solving and process optimization)
 - Not in the desktop taskbar point bug
 - Partial copy problem
 - Many details of the optimization


### Ver2.1 `2014/4 / 2`
-----
#### Update:
 - Drag the folder to upload, the perfect solution (to keep the original directory structure)
 - Decompression optimization; decompression Chinese problem. Unzip the overall speed
 - Increase the shortcut key support directory tree (up and down, left and right to expand the directory tree; copy, paste, cut, delete, open, search, create a new file (folder),)
 - Pdf preview support
 - Mac command shortcuts ctrl-one correspondence
 - Music player and video player independent of each other
 - Lazy loading image, this image from more cases only load the first screen image thumbnails;
 - Edit the file open error, automatic off-label; file open 20M limit (greater than 20M not processed, the browser will get stuck)
 - Label Close Tip: detecting whether there is unsaved files, file modification in real time whether the changes Modifying button states

#### Fix bug: (bug solving and process optimization)
 - A text file to edit the file name containing url encode the error bug
 - At the bottom right-click menu, right-click on the menu position overlapping cause problems
 - When editor open file the cursor problem, deal with: Move to end of line; enter the editor does not display automatically prompts built
 - Iframe open url optimization. Problem solving canvas
 - File editor, remove the loading loading
 - When you delete an error, or upload error also refresh the directory. Remove Wrong Color Tips
 - Right-click context menu to hide the dialog box repair
 - Double-click on the mobile phone side touch =
 - The list of files, right-explorer is not cleared before the election ·
 - Chinese launched a directory tree problem.
 - Ie rename the problem is not selectable state textarea
 - Fixed mac ctrl-election under the context menu appears.
 - Ie the right directory tree compatibility
 -


### Ver2.0 `2014/3 / 2`
-----

#### Fix bug: (bug solving and process optimization)
 - Body right shield (reservation input, textarea)
 - Rename & When creating a new right (edits the system menu)
 - Dialog box does not display a border (the displacement process, opacity: 0)
 - Esc to exit the program mask the function.
 - Turn off the player, is still playing bug
 - Increase the Explorer taskbar. Taskbar Right-added features.
 - The right to increase the dialog function
 - Guest [three categories of users root / default / guest] guest login link at plus. 20min
 - Packers [update user_add, admin / demo; delete webuploader.js thumb less]
 - Editing application permissions to add only the root user can.
 - Save the file is not writable Tip!
 - Unzip results suggest. (Dialog)

#### Upload
 - Dialog display
 - Root login directory modify the server path
 - Artdialog open windows (set the id) is minimized, the display is turned on again
 - After a minimized window, open again dialog display (setting-display)
 - Upload progress Add to size
 - Upload window closes automatically stops all upload queue
 - After dragging, update upload address is the current address. (Before the upload queue so be .bug)
 - Root user non-server path file preview (image, mp3, video, html, swf, ...... php proxy output file contents, http mode)
 - Minimize or close the dialog box, reset the maximum index of the focused window
 - Picture thumbnail generation: less than 5k is not generated (direct output)
 - The list of files to be loaded asynchronously, the data is returned using a callback function mode. Enhanced Experience
 - Select the optimization, rename files & folders, files & folders after a new automatically selected. (F5 increase callback.);
 - Check holding, sorting, etc. When selected if the adjustment, remain selected.
 - Upload files currently selected.
 - F5 to asynchronous (added to mask loading) optimization Folder Opens Experience
 - Select the file to add keyboard character search positioning function (a single character, to more than two characters selected direct response delay 250ms.)
 - Slideshow [fancybox or optimized to rewrite part of the animation, can not afford to shut a problem opening]
 - Editor backspace, not prompted delete.
 - Editor, select the effect to increase
 - Increase not automatically prompt function, configuration items as the global configuration. Affected files subsequently created. Checkmark state.
 - Change the desktop background image after the replacement load []
 - Replace the theme css load after load []
 - Delete. Do not remove the check. Prepare ahead of data
 - Construction of packaging, combined compression. Add version, copyright
 - Automatic Upgrade (local recording version, server js call parameters url, ### version; users ignore this version .cookie statistics.)


### Ver2.0 debug `2014/3 / 2`
-----
#### Fix bug: (bug solving and process optimization)
 - Optimize file open processing
 - Files & Folders: Contains% treatment + number (not reveal other issues, encoenURIComponent - rawurldecode)
 - File downloads, support large file downloads, HTTP.
 After resolving change the sorting - - corresponding to the context menu of sync problems.
 - Optimization of the right to change the listing status, synchronization save the configuration to the server.
 - The file browser opens (a new window click to jump, a not support click, bubbling with sub-elements to achieve click)
 - Optimization profile storage solutions. Directly from the front end of the rear end of the operation key, value
 - Repair Add Favorites problems (open the Settings window and then add failures)
 - Fixed bug tree directory file name in Chinese
 - Optimization pic picture slideshow
 - Optimization of New Files & Folders emptied select state
 - Dialog Component ie8 optimization; tips are not displayed on the taskbar;
 - Optimization of address field too long Edit the status issue
 - Optimization of new, rename the file (folder) highly adaptive problems
 - Firefox ctrl + s system dialog shield
 - Tree directory: Favorite optimization (right-bound); Right operation optimization, optimization of drag (File Manager & Editor)
 - Favorite optimization (right-click> Edit Delete)

#### Update:
**new features**

 - Multi-user access control:
 - You can create security groups, assign functions to the permission group
 - Add a user, select the permissions group belongs.
 - Permission by function into particles, which could be configured, for example, ordinary users, visitors, etc.
 - Search: Search support recursion, you can choose whether to search for the file contents.
 - Increased desktop customization wallpaper.
 - Skin color optimization ok more support.
 - App store, root user can manage applications. Install, modify, delete. Ordinary users can install applications.
 - Added application icon. Corresponding to the right-click functionality.
 - Office documents online preview.
 
Uploading and downloading ** **

 - With a new upload control, with security, a better experience.
 - Drag and drop support for folders, multiple files. Upload automatic filtering does not allow file types
 - Drag and drop upload and unified optimization, file repair webuploader judgment; Firefox drag upload, ie9 + drag upload.
 - Automatic filtering unqualified file upload, upload failed error is returned.

** ** File Editor

 - Editor supports multi-cursor
 - Support for code highlighting almost all programming languages
 - Supports automatic code completion (based on the document, or custom code snapshot)
 - Quick preview
 - Optimization of the perfect solution to save the file. Automatic identification coding conversion. (String escape problems .1 & # '[{' "+ 25% ~ \\\\ ////)
 - Document editing, add favorites
 - Optimization of the music player, the first song played automatically added after adding new music; pause after adding a list of issues resolved before.
 - Optimization of the taskbar, multi-tag; minimize flash issue (left + 10000 visiable)
 - Ctrl, shift when dragging multiple choice optimization (while holding down two keys, can not drag; drag added delay 200ms)
 - The editor in the case did not open file toolbar is not available issues.
 - Search, Replace; vim mode
 - ......

** ** Login Exit

 - Log in page optimization & verification code [ok & Remember password]
 - Need to enter a verification code incorrectly three times to ensure the safety of the system
 - Optimization of automatic logon security, automatic login cookie to save the client information. Join the local ip] [tooken

**System Optimization**

 - Solve slow operation, blocking other operational problems. (The same user session will be locked entrance do release)
 - Front and rear ends substantially all of the code refactoring, front-end modular approach sea.js | require.js modularity.
 - Where there are templates calling (display-- page part php parsing and injected into the configuration page js variable js easy to use.)
 - Add template mechanism; Universal module lazy loading mode; use artTemplate template data binding.
 - Kv storage structure
 - Routing access control
 - Unified backend json output.

### Ver1.21 `2013/11 / 6`
-----
#### Fix bug:
 - File download bug fixes
 - Repair editor auto-complete problems, <aa bb /> -> <aa bb> </a>
 - Compatible part of the server problems.

### Ver1.2 `2013/10 / 16`
-----
#### Fix bug:
 - Setting common external invocation
 - Packaged Chinese garbage problem.
 - Simple, default theme, navbar drop-down menu to the right of where the problem.
 - File management: when the scroll bar up and down over the visible area marquee fix, unity and win consistent operation.
 - File not case sensitive setting, extension get bug
 - Directory read permission judgment, solve the "system error" related issues.

#### Update:
 - The address bar width adaptive optimization, support the browser window adjustment
 - Added remote download; upload function optimization,
 - Optimization of the overall style style,
 - Right menu optimization (Sustainable paste, cut and paste after emptying the clipboard).
 - Create a new file, rename the file highly adaptive optimization
 - Close the debug status error message
 - Picture slideshow optimized to support the browser window adjustment, resolve incidents binding bug, add a picture reflection; add a close button to close the animation feature
 - Optimized Desktop, pop-layer-level issues; taskbar to the top
 - Optimization of multi-tag is not displayed when there is no label on the container label, put to level coverage
 - Beyond the width of the address bar, auto-hide the leftmost content
 - Right-menu state synchronization, sort Initialize the current value, the current value after setting the mark.
 - Optimization Editor: Drag the file into the editor content & content processing.
 - Drag and drop upload message box automatically hidden after a close
 - Setting, editor, when the player is minimized, then called again exhibit the popup
 - Optimize video player, skin and related configuration information is stored in the js, without prior request servers manner, modified skin can be updated directly to the interface.


### Ver1.01 `2013/9 / 10`
-----
#### Fix bug:
 - Add to Favorites
 - Simple, default theme, navbar drop-down menu to the right of where the problem.

#### Update:
 - Add to Favorites, Favorites modify, update files Manage Favorites section.
 - Modify the theme, and modify the theme editor. [Edit area, file management, desktop]
 - Optimization setting part of the code, integrated into a whole.
 - Optimization of debug, increased less compilation, optimization and export functions, compiled after the first operation and then copy


### Ver1.0 `2013.9.1`
-----
#### Update:
 - Optimization of the code modularization, separation of static files that can be deployed separately
 - Editor single logical extraction, complete integration into document management, directory integration file management tree, lazy loading syntax highlighting
 - Multi-label implementation, elastic layer dialog multi-label support, desktop taskbar to achieve; Editor supports multi-tag
 - Elastic layer functions optimized to achieve maximum minimized, minimizing the associated multi-tabbed taskbar management

#### Fix bug:
 - Linux under the browser to open files and folders, Chinese issue
 - Rename & Create & Upload refresh the list of animation, the currently selected failure problem, do not use animation loading.
 - Html5 drag upload optimization


### Ver0.8 `2013.6.15`
-----
#### Update:
 - Overall optimization, to achieve full operating ajax localization further enhance the experience
 - Strong refresh browser, where the path before finally holding
 - Rename, New, add the selected state after the paste operation
 - Code optimization list of topics, redesigned configurability
 - Optimized code, add getTplList templates simplify the configuration associated with obtaining
 - Added setting function, ajax refresh settings. Preview thumbnails increase tips (annotated frame / setting.php)
 - Increase Rename select only part of the function name
 - Increase interoperability ie iframe js api support. Four browser kernel are supported.
 - Open the folder using ajax implementation. It includes a head address bar, the parent directory, the directory tree on the left and favorites
 - History to achieve the perfect, forward and back buttons status changes in real time.
 - Shortcuts backspace achieve backward (left header main functions were added, shielded default history (-1) operation) -

#### Fix bug:
 - Perfection modify windows and linux obtain the file list, Chinese path attribute acquisition failures.
 - Copy, Cut. Empty clipboard contents coverage determination process
 - Fixed some places ajax thread synchronization problem, rename selected after failure to solve the problem
 - Repair return to the upper directory, the root directory is detected
 - Repair under linux audio and video playback, Chinese path problem
 - Repair the file right-click menu location error problem
 - Repair ie problems communicating with each other under the frame js
 - Ajax update the file list under various bug fixes. Further enhance friendly operation
 - Changes in the current directory under repair, the player go away. Players always make reservations now