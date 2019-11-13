<?php declare(strict_types=1);

namespace SfpCodingStandard\Sniffs\Di;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use SlevomatCodingStandard\Helpers\ClassHelper;
use SlevomatCodingStandard\Helpers\TokenHelper;
use Symplify\CodingStandard\TokenRunner\Analyzer\SnifferAnalyzer\Naming;

/**
 * @psalm-suppress UndefinedClass
 */
class ForbiddenInstantiationSniff implements Sniff
{
    public const VIOLATE_FORBIDDEN_INSTANTIATION_AGAINST_LIST = 'ViolateForbiddenInstantiationAgainstList';

    /**
     * @var Naming
     */
    private $naming;

    public function __construct()
    {
        $this->naming = new Naming();
    }

    /**
     * @return int[]
     */
    public function register(): array
    {
        return [T_NEW];
    }

    /**
     * <property name="forbiddenInstantiations" type="array">
     *     <element key="factory" value="class" / >
     */
    public function process(File $file, $position): void
    {
        $classNameTokenPosition = TokenHelper::findNext($file, [T_STRING], $position);
        if ($classNameTokenPosition === null) {
            return;
        }
        $className = $this->naming->getClassName($file, $classNameTokenPosition);

        $ruleRef = 'SfpCodingStandard.Di.ForbiddenInstantiation';

        if (!isset($file->ruleset->ruleset[$ruleRef]['properties']['forbiddenInstantiations'])) {
            return ;
        }

        if (!is_array($file->ruleset->ruleset[$ruleRef]['properties']['forbiddenInstantiations'])) {
            return;
        }

        $classes = $file->ruleset->ruleset[$ruleRef]['properties']['forbiddenInstantiations'];

        $declaredClass = null;
        $declaredClassPosition = TokenHelper::findNext($file, [T_CLASS], 0); // expected PSR-1
        if ($declaredClassPosition !== null) {
            $declaredClass = ltrim(ClassHelper::getFullyQualifiedName($file, $declaredClassPosition), '\\');
        }

        foreach ($classes as $factory => $class) {
            if ($declaredClass != null && $declaredClass === $factory) {
                continue;
            }

            if (is_a($className, $class, true)) {
                $file->addError(sprintf('%s instantiation is forbidden. Use factory %s', $className, $factory), $classNameTokenPosition, self::VIOLATE_FORBIDDEN_INSTANTIATION_AGAINST_LIST);
                break;
            }
        }
    }
}
