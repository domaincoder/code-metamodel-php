<?php
namespace DomainCoder\Metamodel\Code;

use PhpParser\Lexer as PhpLexer;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Interface_;
use PhpParser\Node\Stmt\Property;
use PhpParser\NodeVisitorAbstract;
use PhpParser\Parser as PhpParser;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitor\NameResolver;
use Symfony\Component\Finder\Finder;


require_once __DIR__ .'/../../vendor/autoload.php';

class Context
{
    public $file;
}

class ClassVisitor extends NodeVisitorAbstract
{
    private $context;

    public function __construct(Context $context)
    {
        $this->context = $context;
    }

    public function enterNode(\PhpParser\Node $node)
    {
        if (!($node instanceof Class_ or $node instanceof Interface_)) return;

        $file = $this->context->file;

        // class
        file_put_contents(
            $file->getPath() .'/' . $file->getFilename() .'.class.cache',
            '<?php return unserialize(base64_decode("'. base64_encode(serialize($node)). '"));'
        );
    }
}
class PropertyVisitor extends NodeVisitorAbstract
{
    private $context;

    public function __construct(Context $context)
    {
        $this->context = $context;
    }

    public function enterNode(\PhpParser\Node $node)
    {
        if (!($node instanceof Property)) return;

        $file = $this->context->file;

        file_put_contents(
            $file->getPath() .'/' . $file->getFilename() .'.property.cache',
            '<?php return unserialize(base64_decode("'. base64_encode(serialize($node->props[0])). '"));'
        );
        file_put_contents(
            $file->getPath() .'/' . $file->getFilename() .'.property_base.cache',
            '<?php return unserialize(base64_decode("'. base64_encode(serialize($node)). '"));'
        );
    }
}
class MethodVisitor extends NodeVisitorAbstract
{
    private $context;

    public function __construct(Context $context)
    {
        $this->context = $context;
    }

    public function enterNode(\PhpParser\Node $node)
    {
        if (!($node instanceof ClassMethod)) return;

        $file = $this->context->file;

        file_put_contents(
            $file->getPath() .'/' . $file->getFilename() .'.method.cache',
            '<?php return unserialize(base64_decode("'. base64_encode(serialize($node)). '"));'
        );
    }
}

$context = new Context();

$parser = new PhpParser(new PhpLexer());
$traverser = new NodeTraverser();
$traverser->addVisitor(new NameResolver());
$traverser->addVisitor(new ClassVisitor($context));
$traverser->addVisitor(new PropertyVisitor($context));
$traverser->addVisitor(new MethodVisitor($context));

$finder = new Finder();
$sources = $finder
    ->files()
    ->name('*.php')
    ->notName('*Test.php')
    ->exclude(['cache', 'logs', 'vendor', 'tests', 'Test'])
    ->in(__DIR__.'/1');

foreach ($sources as $file) {

    $context->file = $file;

    /** @var \SplFileInfo $file */
    $path = $file->getRealPath();
    $code = file_get_contents($path);

    $stmts = $parser->parse($code);
    $stmts = $traverser->traverse($stmts);

    file_put_contents(
        $file->getPath() .'/' . $file->getFilename() .'.full.cache',
        '<?php return unserialize(base64_decode("'. base64_encode(serialize($stmts)). '"));'
    );
}

