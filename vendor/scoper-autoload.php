<?php

// scoper-autoload.php @generated by PhpScoper

// Backup the autoloaded Composer files
if (isset($GLOBALS['__composer_autoload_files'])) {
    $existingComposerAutoloadFiles = $GLOBALS['__composer_autoload_files'];
}

$loader = require_once __DIR__.'/autoload.php';
// Ensure InstalledVersions is available
$installedVersionsPath = __DIR__.'/composer/InstalledVersions.php';
if (file_exists($installedVersionsPath)) require_once $installedVersionsPath;

// Restore the backup
if (isset($existingComposerAutoloadFiles)) {
    $GLOBALS['__composer_autoload_files'] = $existingComposerAutoloadFiles;
} else {
    unset($GLOBALS['__composer_autoload_files']);
}

// Class aliases. For more information see:
// https://github.com/humbug/php-scoper/blob/master/docs/further-reading.md#class-aliases
if (!function_exists('humbug_phpscoper_expose_class')) {
    function humbug_phpscoper_expose_class(string $exposed, string $prefixed): void {
        if (!class_exists($exposed, false) && !interface_exists($exposed, false) && !trait_exists($exposed, false)) {
            spl_autoload_call($prefixed);
        }
    }
}
humbug_phpscoper_expose_class('ComposerAutoloaderInitb0a68169fdfe52485c1ffbc0df160067', 'Torch202308\ComposerAutoloaderInitb0a68169fdfe52485c1ffbc0df160067');
humbug_phpscoper_expose_class('Twig_BaseNodeVisitor', 'Torch202308\Twig_BaseNodeVisitor');
humbug_phpscoper_expose_class('Twig_Cache_Filesystem', 'Torch202308\Twig_Cache_Filesystem');
humbug_phpscoper_expose_class('Twig_Cache_Null', 'Torch202308\Twig_Cache_Null');
humbug_phpscoper_expose_class('Twig_CacheInterface', 'Torch202308\Twig_CacheInterface');
humbug_phpscoper_expose_class('Twig_Compiler', 'Torch202308\Twig_Compiler');
humbug_phpscoper_expose_class('Twig_ContainerRuntimeLoader', 'Torch202308\Twig_ContainerRuntimeLoader');
humbug_phpscoper_expose_class('Twig_Environment', 'Torch202308\Twig_Environment');
humbug_phpscoper_expose_class('Twig_Error', 'Torch202308\Twig_Error');
humbug_phpscoper_expose_class('Twig_Error_Loader', 'Torch202308\Twig_Error_Loader');
humbug_phpscoper_expose_class('Twig_Error_Runtime', 'Torch202308\Twig_Error_Runtime');
humbug_phpscoper_expose_class('Twig_Error_Syntax', 'Torch202308\Twig_Error_Syntax');
humbug_phpscoper_expose_class('Twig_ExistsLoaderInterface', 'Torch202308\Twig_ExistsLoaderInterface');
humbug_phpscoper_expose_class('Twig_ExpressionParser', 'Torch202308\Twig_ExpressionParser');
humbug_phpscoper_expose_class('Twig_Extension', 'Torch202308\Twig_Extension');
humbug_phpscoper_expose_class('Twig_Extension_Core', 'Torch202308\Twig_Extension_Core');
humbug_phpscoper_expose_class('Twig_Extension_Debug', 'Torch202308\Twig_Extension_Debug');
humbug_phpscoper_expose_class('Twig_Extension_Escaper', 'Torch202308\Twig_Extension_Escaper');
humbug_phpscoper_expose_class('Twig_Extension_GlobalsInterface', 'Torch202308\Twig_Extension_GlobalsInterface');
humbug_phpscoper_expose_class('Twig_Extension_InitRuntimeInterface', 'Torch202308\Twig_Extension_InitRuntimeInterface');
humbug_phpscoper_expose_class('Twig_Extension_Optimizer', 'Torch202308\Twig_Extension_Optimizer');
humbug_phpscoper_expose_class('Twig_Extension_Profiler', 'Torch202308\Twig_Extension_Profiler');
humbug_phpscoper_expose_class('Twig_Extension_Sandbox', 'Torch202308\Twig_Extension_Sandbox');
humbug_phpscoper_expose_class('Twig_Extension_Staging', 'Torch202308\Twig_Extension_Staging');
humbug_phpscoper_expose_class('Twig_Extension_StringLoader', 'Torch202308\Twig_Extension_StringLoader');
humbug_phpscoper_expose_class('Twig_ExtensionInterface', 'Torch202308\Twig_ExtensionInterface');
humbug_phpscoper_expose_class('Twig_ExtensionSet', 'Torch202308\Twig_ExtensionSet');
humbug_phpscoper_expose_class('Twig_FactoryRuntimeLoader', 'Torch202308\Twig_FactoryRuntimeLoader');
humbug_phpscoper_expose_class('Twig_FileExtensionEscapingStrategy', 'Torch202308\Twig_FileExtensionEscapingStrategy');
humbug_phpscoper_expose_class('Twig_Filter', 'Torch202308\Twig_Filter');
humbug_phpscoper_expose_class('Twig_Function', 'Torch202308\Twig_Function');
humbug_phpscoper_expose_class('Twig_Lexer', 'Torch202308\Twig_Lexer');
humbug_phpscoper_expose_class('Twig_Loader_Array', 'Torch202308\Twig_Loader_Array');
humbug_phpscoper_expose_class('Twig_Loader_Chain', 'Torch202308\Twig_Loader_Chain');
humbug_phpscoper_expose_class('Twig_Loader_Filesystem', 'Torch202308\Twig_Loader_Filesystem');
humbug_phpscoper_expose_class('Twig_LoaderInterface', 'Torch202308\Twig_LoaderInterface');
humbug_phpscoper_expose_class('Twig_Markup', 'Torch202308\Twig_Markup');
humbug_phpscoper_expose_class('Twig_Node', 'Torch202308\Twig_Node');
humbug_phpscoper_expose_class('Twig_Node_AutoEscape', 'Torch202308\Twig_Node_AutoEscape');
humbug_phpscoper_expose_class('Twig_Node_Block', 'Torch202308\Twig_Node_Block');
humbug_phpscoper_expose_class('Twig_Node_BlockReference', 'Torch202308\Twig_Node_BlockReference');
humbug_phpscoper_expose_class('Twig_Node_Body', 'Torch202308\Twig_Node_Body');
humbug_phpscoper_expose_class('Twig_Node_CheckSecurity', 'Torch202308\Twig_Node_CheckSecurity');
humbug_phpscoper_expose_class('Twig_Node_Deprecated', 'Torch202308\Twig_Node_Deprecated');
humbug_phpscoper_expose_class('Twig_Node_Do', 'Torch202308\Twig_Node_Do');
humbug_phpscoper_expose_class('Twig_Node_Embed', 'Torch202308\Twig_Node_Embed');
humbug_phpscoper_expose_class('Twig_Node_Expression', 'Torch202308\Twig_Node_Expression');
humbug_phpscoper_expose_class('Twig_Node_Expression_Array', 'Torch202308\Twig_Node_Expression_Array');
humbug_phpscoper_expose_class('Twig_Node_Expression_AssignName', 'Torch202308\Twig_Node_Expression_AssignName');
humbug_phpscoper_expose_class('Twig_Node_Expression_Binary', 'Torch202308\Twig_Node_Expression_Binary');
humbug_phpscoper_expose_class('Twig_Node_Expression_Binary_Add', 'Torch202308\Twig_Node_Expression_Binary_Add');
humbug_phpscoper_expose_class('Twig_Node_Expression_Binary_And', 'Torch202308\Twig_Node_Expression_Binary_And');
humbug_phpscoper_expose_class('Twig_Node_Expression_Binary_BitwiseAnd', 'Torch202308\Twig_Node_Expression_Binary_BitwiseAnd');
humbug_phpscoper_expose_class('Twig_Node_Expression_Binary_BitwiseOr', 'Torch202308\Twig_Node_Expression_Binary_BitwiseOr');
humbug_phpscoper_expose_class('Twig_Node_Expression_Binary_BitwiseXor', 'Torch202308\Twig_Node_Expression_Binary_BitwiseXor');
humbug_phpscoper_expose_class('Twig_Node_Expression_Binary_Concat', 'Torch202308\Twig_Node_Expression_Binary_Concat');
humbug_phpscoper_expose_class('Twig_Node_Expression_Binary_Div', 'Torch202308\Twig_Node_Expression_Binary_Div');
humbug_phpscoper_expose_class('Twig_Node_Expression_Binary_EndsWith', 'Torch202308\Twig_Node_Expression_Binary_EndsWith');
humbug_phpscoper_expose_class('Twig_Node_Expression_Binary_Equal', 'Torch202308\Twig_Node_Expression_Binary_Equal');
humbug_phpscoper_expose_class('Twig_Node_Expression_Binary_FloorDiv', 'Torch202308\Twig_Node_Expression_Binary_FloorDiv');
humbug_phpscoper_expose_class('Twig_Node_Expression_Binary_Greater', 'Torch202308\Twig_Node_Expression_Binary_Greater');
humbug_phpscoper_expose_class('Twig_Node_Expression_Binary_GreaterEqual', 'Torch202308\Twig_Node_Expression_Binary_GreaterEqual');
humbug_phpscoper_expose_class('Twig_Node_Expression_Binary_In', 'Torch202308\Twig_Node_Expression_Binary_In');
humbug_phpscoper_expose_class('Twig_Node_Expression_Binary_Less', 'Torch202308\Twig_Node_Expression_Binary_Less');
humbug_phpscoper_expose_class('Twig_Node_Expression_Binary_LessEqual', 'Torch202308\Twig_Node_Expression_Binary_LessEqual');
humbug_phpscoper_expose_class('Twig_Node_Expression_Binary_Matches', 'Torch202308\Twig_Node_Expression_Binary_Matches');
humbug_phpscoper_expose_class('Twig_Node_Expression_Binary_Mod', 'Torch202308\Twig_Node_Expression_Binary_Mod');
humbug_phpscoper_expose_class('Twig_Node_Expression_Binary_Mul', 'Torch202308\Twig_Node_Expression_Binary_Mul');
humbug_phpscoper_expose_class('Twig_Node_Expression_Binary_NotEqual', 'Torch202308\Twig_Node_Expression_Binary_NotEqual');
humbug_phpscoper_expose_class('Twig_Node_Expression_Binary_NotIn', 'Torch202308\Twig_Node_Expression_Binary_NotIn');
humbug_phpscoper_expose_class('Twig_Node_Expression_Binary_Or', 'Torch202308\Twig_Node_Expression_Binary_Or');
humbug_phpscoper_expose_class('Twig_Node_Expression_Binary_Power', 'Torch202308\Twig_Node_Expression_Binary_Power');
humbug_phpscoper_expose_class('Twig_Node_Expression_Binary_Range', 'Torch202308\Twig_Node_Expression_Binary_Range');
humbug_phpscoper_expose_class('Twig_Node_Expression_Binary_StartsWith', 'Torch202308\Twig_Node_Expression_Binary_StartsWith');
humbug_phpscoper_expose_class('Twig_Node_Expression_Binary_Sub', 'Torch202308\Twig_Node_Expression_Binary_Sub');
humbug_phpscoper_expose_class('Twig_Node_Expression_BlockReference', 'Torch202308\Twig_Node_Expression_BlockReference');
humbug_phpscoper_expose_class('Twig_Node_Expression_Call', 'Torch202308\Twig_Node_Expression_Call');
humbug_phpscoper_expose_class('Twig_Node_Expression_Conditional', 'Torch202308\Twig_Node_Expression_Conditional');
humbug_phpscoper_expose_class('Twig_Node_Expression_Constant', 'Torch202308\Twig_Node_Expression_Constant');
humbug_phpscoper_expose_class('Twig_Node_Expression_Filter', 'Torch202308\Twig_Node_Expression_Filter');
humbug_phpscoper_expose_class('Twig_Node_Expression_Filter_Default', 'Torch202308\Twig_Node_Expression_Filter_Default');
humbug_phpscoper_expose_class('Twig_Node_Expression_Function', 'Torch202308\Twig_Node_Expression_Function');
humbug_phpscoper_expose_class('Twig_Node_Expression_GetAttr', 'Torch202308\Twig_Node_Expression_GetAttr');
humbug_phpscoper_expose_class('Twig_Node_Expression_MethodCall', 'Torch202308\Twig_Node_Expression_MethodCall');
humbug_phpscoper_expose_class('Twig_Node_Expression_Name', 'Torch202308\Twig_Node_Expression_Name');
humbug_phpscoper_expose_class('Twig_Node_Expression_NullCoalesce', 'Torch202308\Twig_Node_Expression_NullCoalesce');
humbug_phpscoper_expose_class('Twig_Node_Expression_Parent', 'Torch202308\Twig_Node_Expression_Parent');
humbug_phpscoper_expose_class('Twig_Node_Expression_TempName', 'Torch202308\Twig_Node_Expression_TempName');
humbug_phpscoper_expose_class('Twig_Node_Expression_Test', 'Torch202308\Twig_Node_Expression_Test');
humbug_phpscoper_expose_class('Twig_Node_Expression_Test_Constant', 'Torch202308\Twig_Node_Expression_Test_Constant');
humbug_phpscoper_expose_class('Twig_Node_Expression_Test_Defined', 'Torch202308\Twig_Node_Expression_Test_Defined');
humbug_phpscoper_expose_class('Twig_Node_Expression_Test_Divisibleby', 'Torch202308\Twig_Node_Expression_Test_Divisibleby');
humbug_phpscoper_expose_class('Twig_Node_Expression_Test_Even', 'Torch202308\Twig_Node_Expression_Test_Even');
humbug_phpscoper_expose_class('Twig_Node_Expression_Test_Null', 'Torch202308\Twig_Node_Expression_Test_Null');
humbug_phpscoper_expose_class('Twig_Node_Expression_Test_Odd', 'Torch202308\Twig_Node_Expression_Test_Odd');
humbug_phpscoper_expose_class('Twig_Node_Expression_Test_Sameas', 'Torch202308\Twig_Node_Expression_Test_Sameas');
humbug_phpscoper_expose_class('Twig_Node_Expression_Unary', 'Torch202308\Twig_Node_Expression_Unary');
humbug_phpscoper_expose_class('Twig_Node_Expression_Unary_Neg', 'Torch202308\Twig_Node_Expression_Unary_Neg');
humbug_phpscoper_expose_class('Twig_Node_Expression_Unary_Not', 'Torch202308\Twig_Node_Expression_Unary_Not');
humbug_phpscoper_expose_class('Twig_Node_Expression_Unary_Pos', 'Torch202308\Twig_Node_Expression_Unary_Pos');
humbug_phpscoper_expose_class('Twig_Node_Flush', 'Torch202308\Twig_Node_Flush');
humbug_phpscoper_expose_class('Twig_Node_For', 'Torch202308\Twig_Node_For');
humbug_phpscoper_expose_class('Twig_Node_ForLoop', 'Torch202308\Twig_Node_ForLoop');
humbug_phpscoper_expose_class('Twig_Node_If', 'Torch202308\Twig_Node_If');
humbug_phpscoper_expose_class('Twig_Node_Import', 'Torch202308\Twig_Node_Import');
humbug_phpscoper_expose_class('Twig_Node_Include', 'Torch202308\Twig_Node_Include');
humbug_phpscoper_expose_class('Twig_Node_Macro', 'Torch202308\Twig_Node_Macro');
humbug_phpscoper_expose_class('Twig_Node_Module', 'Torch202308\Twig_Node_Module');
humbug_phpscoper_expose_class('Twig_Node_Print', 'Torch202308\Twig_Node_Print');
humbug_phpscoper_expose_class('Twig_Node_Sandbox', 'Torch202308\Twig_Node_Sandbox');
humbug_phpscoper_expose_class('Twig_Node_SandboxedPrint', 'Torch202308\Twig_Node_SandboxedPrint');
humbug_phpscoper_expose_class('Twig_Node_Set', 'Torch202308\Twig_Node_Set');
humbug_phpscoper_expose_class('Twig_Node_Spaceless', 'Torch202308\Twig_Node_Spaceless');
humbug_phpscoper_expose_class('Twig_Node_Text', 'Torch202308\Twig_Node_Text');
humbug_phpscoper_expose_class('Twig_Node_With', 'Torch202308\Twig_Node_With');
humbug_phpscoper_expose_class('Twig_NodeCaptureInterface', 'Torch202308\Twig_NodeCaptureInterface');
humbug_phpscoper_expose_class('Twig_NodeOutputInterface', 'Torch202308\Twig_NodeOutputInterface');
humbug_phpscoper_expose_class('Twig_NodeTraverser', 'Torch202308\Twig_NodeTraverser');
humbug_phpscoper_expose_class('Twig_NodeVisitor_Escaper', 'Torch202308\Twig_NodeVisitor_Escaper');
humbug_phpscoper_expose_class('Twig_NodeVisitor_Optimizer', 'Torch202308\Twig_NodeVisitor_Optimizer');
humbug_phpscoper_expose_class('Twig_NodeVisitor_SafeAnalysis', 'Torch202308\Twig_NodeVisitor_SafeAnalysis');
humbug_phpscoper_expose_class('Twig_NodeVisitor_Sandbox', 'Torch202308\Twig_NodeVisitor_Sandbox');
humbug_phpscoper_expose_class('Twig_NodeVisitorInterface', 'Torch202308\Twig_NodeVisitorInterface');
humbug_phpscoper_expose_class('Twig_Parser', 'Torch202308\Twig_Parser');
humbug_phpscoper_expose_class('Twig_Profiler_Dumper_Base', 'Torch202308\Twig_Profiler_Dumper_Base');
humbug_phpscoper_expose_class('Twig_Profiler_Dumper_Blackfire', 'Torch202308\Twig_Profiler_Dumper_Blackfire');
humbug_phpscoper_expose_class('Twig_Profiler_Dumper_Html', 'Torch202308\Twig_Profiler_Dumper_Html');
humbug_phpscoper_expose_class('Twig_Profiler_Dumper_Text', 'Torch202308\Twig_Profiler_Dumper_Text');
humbug_phpscoper_expose_class('Twig_Profiler_Node_EnterProfile', 'Torch202308\Twig_Profiler_Node_EnterProfile');
humbug_phpscoper_expose_class('Twig_Profiler_Node_LeaveProfile', 'Torch202308\Twig_Profiler_Node_LeaveProfile');
humbug_phpscoper_expose_class('Twig_Profiler_NodeVisitor_Profiler', 'Torch202308\Twig_Profiler_NodeVisitor_Profiler');
humbug_phpscoper_expose_class('Twig_Profiler_Profile', 'Torch202308\Twig_Profiler_Profile');
humbug_phpscoper_expose_class('Twig_RuntimeLoaderInterface', 'Torch202308\Twig_RuntimeLoaderInterface');
humbug_phpscoper_expose_class('Twig_Sandbox_SecurityError', 'Torch202308\Twig_Sandbox_SecurityError');
humbug_phpscoper_expose_class('Twig_Sandbox_SecurityNotAllowedFilterError', 'Torch202308\Twig_Sandbox_SecurityNotAllowedFilterError');
humbug_phpscoper_expose_class('Twig_Sandbox_SecurityNotAllowedFunctionError', 'Torch202308\Twig_Sandbox_SecurityNotAllowedFunctionError');
humbug_phpscoper_expose_class('Twig_Sandbox_SecurityNotAllowedMethodError', 'Torch202308\Twig_Sandbox_SecurityNotAllowedMethodError');
humbug_phpscoper_expose_class('Twig_Sandbox_SecurityNotAllowedPropertyError', 'Torch202308\Twig_Sandbox_SecurityNotAllowedPropertyError');
humbug_phpscoper_expose_class('Twig_Sandbox_SecurityNotAllowedTagError', 'Torch202308\Twig_Sandbox_SecurityNotAllowedTagError');
humbug_phpscoper_expose_class('Twig_Sandbox_SecurityPolicy', 'Torch202308\Twig_Sandbox_SecurityPolicy');
humbug_phpscoper_expose_class('Twig_Sandbox_SecurityPolicyInterface', 'Torch202308\Twig_Sandbox_SecurityPolicyInterface');
humbug_phpscoper_expose_class('Twig_SimpleFilter', 'Torch202308\Twig_SimpleFilter');
humbug_phpscoper_expose_class('Twig_SimpleFunction', 'Torch202308\Twig_SimpleFunction');
humbug_phpscoper_expose_class('Twig_SimpleTest', 'Torch202308\Twig_SimpleTest');
humbug_phpscoper_expose_class('Twig_Source', 'Torch202308\Twig_Source');
humbug_phpscoper_expose_class('Twig_SourceContextLoaderInterface', 'Torch202308\Twig_SourceContextLoaderInterface');
humbug_phpscoper_expose_class('Twig_Template', 'Torch202308\Twig_Template');
humbug_phpscoper_expose_class('Twig_TemplateWrapper', 'Torch202308\Twig_TemplateWrapper');
humbug_phpscoper_expose_class('Twig_Test', 'Torch202308\Twig_Test');
humbug_phpscoper_expose_class('Twig_Token', 'Torch202308\Twig_Token');
humbug_phpscoper_expose_class('Twig_TokenParser', 'Torch202308\Twig_TokenParser');
humbug_phpscoper_expose_class('Twig_TokenParser_AutoEscape', 'Torch202308\Twig_TokenParser_AutoEscape');
humbug_phpscoper_expose_class('Twig_TokenParser_Block', 'Torch202308\Twig_TokenParser_Block');
humbug_phpscoper_expose_class('Twig_TokenParser_Deprecated', 'Torch202308\Twig_TokenParser_Deprecated');
humbug_phpscoper_expose_class('Twig_TokenParser_Do', 'Torch202308\Twig_TokenParser_Do');
humbug_phpscoper_expose_class('Twig_TokenParser_Embed', 'Torch202308\Twig_TokenParser_Embed');
humbug_phpscoper_expose_class('Twig_TokenParser_Extends', 'Torch202308\Twig_TokenParser_Extends');
humbug_phpscoper_expose_class('Twig_TokenParser_Filter', 'Torch202308\Twig_TokenParser_Filter');
humbug_phpscoper_expose_class('Twig_TokenParser_Flush', 'Torch202308\Twig_TokenParser_Flush');
humbug_phpscoper_expose_class('Twig_TokenParser_For', 'Torch202308\Twig_TokenParser_For');
humbug_phpscoper_expose_class('Twig_TokenParser_From', 'Torch202308\Twig_TokenParser_From');
humbug_phpscoper_expose_class('Twig_TokenParser_If', 'Torch202308\Twig_TokenParser_If');
humbug_phpscoper_expose_class('Twig_TokenParser_Import', 'Torch202308\Twig_TokenParser_Import');
humbug_phpscoper_expose_class('Twig_TokenParser_Include', 'Torch202308\Twig_TokenParser_Include');
humbug_phpscoper_expose_class('Twig_TokenParser_Macro', 'Torch202308\Twig_TokenParser_Macro');
humbug_phpscoper_expose_class('Twig_TokenParser_Sandbox', 'Torch202308\Twig_TokenParser_Sandbox');
humbug_phpscoper_expose_class('Twig_TokenParser_Set', 'Torch202308\Twig_TokenParser_Set');
humbug_phpscoper_expose_class('Twig_TokenParser_Spaceless', 'Torch202308\Twig_TokenParser_Spaceless');
humbug_phpscoper_expose_class('Twig_TokenParser_Use', 'Torch202308\Twig_TokenParser_Use');
humbug_phpscoper_expose_class('Twig_TokenParser_With', 'Torch202308\Twig_TokenParser_With');
humbug_phpscoper_expose_class('Twig_TokenParserInterface', 'Torch202308\Twig_TokenParserInterface');
humbug_phpscoper_expose_class('Twig_TokenStream', 'Torch202308\Twig_TokenStream');
humbug_phpscoper_expose_class('Twig_Util_DeprecationCollector', 'Torch202308\Twig_Util_DeprecationCollector');
humbug_phpscoper_expose_class('Twig_Util_TemplateDirIterator', 'Torch202308\Twig_Util_TemplateDirIterator');

// Function aliases. For more information see:
// https://github.com/humbug/php-scoper/blob/master/docs/further-reading.md#function-aliases
// if (!function_exists('_twig_default_filter')) { function _twig_default_filter() { return \Torch202308\_twig_default_filter(...func_get_args()); } }
// if (!function_exists('setproctitle')) { function setproctitle() { return \Torch202308\setproctitle(...func_get_args()); } }
// if (!function_exists('trigger_deprecation')) { function trigger_deprecation() { return \Torch202308\trigger_deprecation(...func_get_args()); } }
// if (!function_exists('twig_array_batch')) { function twig_array_batch() { return \Torch202308\twig_array_batch(...func_get_args()); } }
// if (!function_exists('twig_array_column')) { function twig_array_column() { return \Torch202308\twig_array_column(...func_get_args()); } }
// if (!function_exists('twig_array_filter')) { function twig_array_filter() { return \Torch202308\twig_array_filter(...func_get_args()); } }
// if (!function_exists('twig_array_map')) { function twig_array_map() { return \Torch202308\twig_array_map(...func_get_args()); } }
// if (!function_exists('twig_array_merge')) { function twig_array_merge() { return \Torch202308\twig_array_merge(...func_get_args()); } }
// if (!function_exists('twig_array_reduce')) { function twig_array_reduce() { return \Torch202308\twig_array_reduce(...func_get_args()); } }
// if (!function_exists('twig_call_macro')) { function twig_call_macro() { return \Torch202308\twig_call_macro(...func_get_args()); } }
// if (!function_exists('twig_capitalize_string_filter')) { function twig_capitalize_string_filter() { return \Torch202308\twig_capitalize_string_filter(...func_get_args()); } }
// if (!function_exists('twig_check_arrow_in_sandbox')) { function twig_check_arrow_in_sandbox() { return \Torch202308\twig_check_arrow_in_sandbox(...func_get_args()); } }
// if (!function_exists('twig_constant')) { function twig_constant() { return \Torch202308\twig_constant(...func_get_args()); } }
// if (!function_exists('twig_constant_is_defined')) { function twig_constant_is_defined() { return \Torch202308\twig_constant_is_defined(...func_get_args()); } }
// if (!function_exists('twig_convert_encoding')) { function twig_convert_encoding() { return \Torch202308\twig_convert_encoding(...func_get_args()); } }
// if (!function_exists('twig_cycle')) { function twig_cycle() { return \Torch202308\twig_cycle(...func_get_args()); } }
// if (!function_exists('twig_date_converter')) { function twig_date_converter() { return \Torch202308\twig_date_converter(...func_get_args()); } }
// if (!function_exists('twig_date_format_filter')) { function twig_date_format_filter() { return \Torch202308\twig_date_format_filter(...func_get_args()); } }
// if (!function_exists('twig_date_modify_filter')) { function twig_date_modify_filter() { return \Torch202308\twig_date_modify_filter(...func_get_args()); } }
// if (!function_exists('twig_ensure_traversable')) { function twig_ensure_traversable() { return \Torch202308\twig_ensure_traversable(...func_get_args()); } }
// if (!function_exists('twig_escape_filter')) { function twig_escape_filter() { return \Torch202308\twig_escape_filter(...func_get_args()); } }
// if (!function_exists('twig_escape_filter_is_safe')) { function twig_escape_filter_is_safe() { return \Torch202308\twig_escape_filter_is_safe(...func_get_args()); } }
// if (!function_exists('twig_first')) { function twig_first() { return \Torch202308\twig_first(...func_get_args()); } }
// if (!function_exists('twig_get_array_keys_filter')) { function twig_get_array_keys_filter() { return \Torch202308\twig_get_array_keys_filter(...func_get_args()); } }
// if (!function_exists('twig_get_attribute')) { function twig_get_attribute() { return \Torch202308\twig_get_attribute(...func_get_args()); } }
// if (!function_exists('twig_in_filter')) { function twig_in_filter() { return \Torch202308\twig_in_filter(...func_get_args()); } }
// if (!function_exists('twig_include')) { function twig_include() { return \Torch202308\twig_include(...func_get_args()); } }
// if (!function_exists('twig_join_filter')) { function twig_join_filter() { return \Torch202308\twig_join_filter(...func_get_args()); } }
// if (!function_exists('twig_last')) { function twig_last() { return \Torch202308\twig_last(...func_get_args()); } }
// if (!function_exists('twig_length_filter')) { function twig_length_filter() { return \Torch202308\twig_length_filter(...func_get_args()); } }
// if (!function_exists('twig_lower_filter')) { function twig_lower_filter() { return \Torch202308\twig_lower_filter(...func_get_args()); } }
// if (!function_exists('twig_nl2br')) { function twig_nl2br() { return \Torch202308\twig_nl2br(...func_get_args()); } }
// if (!function_exists('twig_number_format_filter')) { function twig_number_format_filter() { return \Torch202308\twig_number_format_filter(...func_get_args()); } }
// if (!function_exists('twig_random')) { function twig_random() { return \Torch202308\twig_random(...func_get_args()); } }
// if (!function_exists('twig_raw_filter')) { function twig_raw_filter() { return \Torch202308\twig_raw_filter(...func_get_args()); } }
// if (!function_exists('twig_replace_filter')) { function twig_replace_filter() { return \Torch202308\twig_replace_filter(...func_get_args()); } }
// if (!function_exists('twig_reverse_filter')) { function twig_reverse_filter() { return \Torch202308\twig_reverse_filter(...func_get_args()); } }
// if (!function_exists('twig_round')) { function twig_round() { return \Torch202308\twig_round(...func_get_args()); } }
// if (!function_exists('twig_slice')) { function twig_slice() { return \Torch202308\twig_slice(...func_get_args()); } }
// if (!function_exists('twig_sort_filter')) { function twig_sort_filter() { return \Torch202308\twig_sort_filter(...func_get_args()); } }
// if (!function_exists('twig_source')) { function twig_source() { return \Torch202308\twig_source(...func_get_args()); } }
// if (!function_exists('twig_spaceless')) { function twig_spaceless() { return \Torch202308\twig_spaceless(...func_get_args()); } }
// if (!function_exists('twig_split_filter')) { function twig_split_filter() { return \Torch202308\twig_split_filter(...func_get_args()); } }
// if (!function_exists('twig_sprintf')) { function twig_sprintf() { return \Torch202308\twig_sprintf(...func_get_args()); } }
// if (!function_exists('twig_striptags')) { function twig_striptags() { return \Torch202308\twig_striptags(...func_get_args()); } }
// if (!function_exists('twig_template_from_string')) { function twig_template_from_string() { return \Torch202308\twig_template_from_string(...func_get_args()); } }
// if (!function_exists('twig_test_empty')) { function twig_test_empty() { return \Torch202308\twig_test_empty(...func_get_args()); } }
// if (!function_exists('twig_test_iterable')) { function twig_test_iterable() { return \Torch202308\twig_test_iterable(...func_get_args()); } }
// if (!function_exists('twig_title_string_filter')) { function twig_title_string_filter() { return \Torch202308\twig_title_string_filter(...func_get_args()); } }
// if (!function_exists('twig_to_array')) { function twig_to_array() { return \Torch202308\twig_to_array(...func_get_args()); } }
// if (!function_exists('twig_trim_filter')) { function twig_trim_filter() { return \Torch202308\twig_trim_filter(...func_get_args()); } }
// if (!function_exists('twig_upper_filter')) { function twig_upper_filter() { return \Torch202308\twig_upper_filter(...func_get_args()); } }
// if (!function_exists('twig_urlencode_filter')) { function twig_urlencode_filter() { return \Torch202308\twig_urlencode_filter(...func_get_args()); } }
// if (!function_exists('twig_var_dump')) { function twig_var_dump() { return \Torch202308\twig_var_dump(...func_get_args()); } }

return $loader;
