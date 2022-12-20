<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\CssSelector\XPath\Extension;

use Symfony\Component\CssSelector\Exception\ExpressionErrorException;
use Symfony\Component\CssSelector\XPath\XPathExpr;

/**
 * XPath expression translator pseudo-class extension.
 *
 * This component is a port of the Python cssselect library,
 * which is copyright Ian Bicking, @see https://github.com/SimonSapin/cssselect.
 *
 * @author Jean-François Simon <jeanfrancois.simon@sensiolabs.com>
 *
 * @internal
 */
class PseudoClassExtension extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    public function getPseudoClassTranslators()
    {
        return array(
            'root' => array($this, 'translateRoot'),
            'first-child' => array($this, 'translateFirstChild'),
            'last-child' => array($this, 'translateLastChild'),
            'first-of-type' => array($this, 'translateFirstOfType'),
            'last-of-type' => array($this, 'translateLastOfType'),
            'only-child' => array($this, 'translateOnlyChild'),
            'only-of-type' => array($this, 'translateOnlyOfType'),
            'empty' => array($this, 'translateEmpty'),
			//Custom classes
			'button'=> array($this,'translateButton'),
			'first'=> array($this,'translateFirst'),
			'last'=> array($this,'translateLast'),
			'submit'=> array($this,'translateSubmit'),
			'parent'=> array($this,'translateParent'),
			'has'=> array($this,'translateHas'),
			'visible'=> array($this,'translateVisible'),
			'hidden'=> array($this,'translateHidden'),
			'file'=> array($this,'translateFile'),
			'selected'=> array($this,'translateSelected'),
			'header'=> array($this,'translateHeader'),
			'input'=> array($this,'translateInput'),
			'text'=> array($this,'translateText'),
			'radio'=> array($this,'translateRadio'),
			'checked'=> array($this,'translateChecked'),
			'disabled'=> array($this,'translateDisabled'),
			'checkbox'=> array($this,'translateCheckbox'),
			'odd'=> array($this,'translateOdd'),
			'even'=> array($this,'translateEven'),
			'contains'=>array($this,'translateContains'),
        );
    }

    /**
     * @param XPathExpr $xpath
     *
     * @return XPathExpr
     */
    public function translateRoot(XPathExpr $xpath)
    {
        return $xpath->addCondition('not(parent::*)');
    }

    /**
     * @param XPathExpr $xpath
     *
     * @return XPathExpr
     */
    public function translateFirstChild(XPathExpr $xpath)
    {
        return $xpath
            ->addStarPrefix()
            ->addNameTest()
            ->addCondition('position() = 1');
    }

    /**
     * @param XPathExpr $xpath
     *
     * @return XPathExpr
     */
    public function translateLastChild(XPathExpr $xpath)
    {
        return $xpath
            ->addStarPrefix()
            ->addNameTest()
            ->addCondition('position() = last()');
    }
	 public function translateEven(XPathExpr $xpath)
    {
        return $xpath
            ->addStarPrefix()
            ->addNameTest()
            ->addCondition('position() mod 2=0');
    }
	 public function translateOdd(XPathExpr $xpath)
    {
        return $xpath
            ->addStarPrefix()
            ->addNameTest()
            ->addCondition('not(position() mod 2=0)');
    }

    /**
     * @param XPathExpr $xpath
     *
     * @return XPathExpr
     *
     * @throws ExpressionErrorException
     */
    public function translateFirstOfType(XPathExpr $xpath)
    {
        if ('*' === $xpath->getElement()) {
            throw new ExpressionErrorException('"*:first-of-type" is not implemented.');
        }

        return $xpath
            ->addStarPrefix()
            ->addCondition('position() = 1');
    }

    /**
     * @param XPathExpr $xpath
     *
     * @return XPathExpr
     *
     * @throws ExpressionErrorException
     */
    public function translateLastOfType(XPathExpr $xpath)
    {
        if ('*' === $xpath->getElement()) {
            throw new ExpressionErrorException('"*:last-of-type" is not implemented.');
        }

        return $xpath
            ->addStarPrefix()
            ->addCondition('position() = last()');
    }

    /**
     * @param XPathExpr $xpath
     *
     * @return XPathExpr
     */
    public function translateOnlyChild(XPathExpr $xpath)
    {
        return $xpath
            ->addStarPrefix()
            ->addNameTest()
            ->addCondition('last() = 1');
    }

    /**
     * @param XPathExpr $xpath
     *
     * @return XPathExpr
     *
     * @throws ExpressionErrorException
     */
    public function translateOnlyOfType(XPathExpr $xpath)
    {
        if ('*' === $xpath->getElement()) {
            throw new ExpressionErrorException('"*:only-of-type" is not implemented.');
        }

        return $xpath->addCondition('last() = 1');
    }

    /**
     * @param XPathExpr $xpath
     *
     * @return XPathExpr
     */
    public function translateEmpty(XPathExpr $xpath)
    {
        return $xpath->addCondition('not(*) and not(string-length())');
    }
	
	 public function translateFirst(XPathExpr $xpath)
    {
		//return $xpath->addCondition('((string-length() > 0) or (*))');
			$path = $xpath->getCondition();
			
			if(!empty($path)){
				
				return $xpath->append(':first');
				
			}else{
				
				return $xpath->append(':first');
			
			}
		
    }
	 public function translateLast(XPathExpr $xpath)
    {
        $path = $xpath->getCondition();
			if(!empty($path)){
				$xpath->append(':last');
			}else{
				 $xpath->append(':last');
			}
       
		return $xpath;
    }
	 public function translateSubmit(XPathExpr $xpath)
    {
        return $xpath->addCondition("((name(.) = 'button' and @type = 'submit') or (name(.) = 'input' and @type = 'submit'))");
    }
	 public function translateParent(XPathExpr $xpath)
    {
        return $xpath->addCondition("((string-length() > 0) or (*))");
    }
	public function translateContains(XPathExpr $xpath){
		 return $xpath->addCondition("(descendant::text()[string-length(normalize-space(.)) > 0])");
	}
	 public function translateHas(XPathExpr $xpath)
    {
        return $xpath->addCondition("(descendant::*[not(string-length(name(.))=0)])");
    }
	 public function translateHidden(XPathExpr $xpath)
    {
		$l = "(name(.)= 'input' and @type = 'hidden')
		 or name(.)= 'option' 
		 or name(.)= 'title' 
		 or name(.)= 'script' 
		 or name(.)= 'head' 
		 or name(.)= 'meta' 
		 or name(.)= 'link' 
		 or (@width = 0 or @height = 0)
		 or (contains(@style,'width:0') or contains(@style,'opacity:0') or contains(@style,'height:0')) ";
        return $xpath->addCondition("
		 (
		 $l
		 or ancestor::*[$l]
		 )
		
		");
    }
	
	public function translateVisible(XPathExpr $xpath){
		$l = "(name(.)= 'input' and @type = 'hidden')
		 or name(.)= 'option' 
		 or name(.)= 'title' 
		 or name(.)= 'script' 
		 or name(.)= 'head' 
		 or name(.)= 'meta' 
		 or name(.)= 'link' 
		 or (@width = 0 or @height = 0) 
		 or (contains(@style,'width:0') or contains(@style,'opacity:0') or contains(@style,'height:0'))";
		return $xpath->addCondition("not(
		$l 
		 or ancestor::*[$l]
		 )");
	}
	public function translateFile(XPathExpr $xpath)
    {
        return $xpath->addCondition("(name(.) = 'input' and @type = 'file')");
    }
	public function translateText(XPathExpr $xpath)
    {
        return $xpath->addCondition("(name(.) = 'input' and @type = 'text')");
    }
	public function translateRadio(XPathExpr $xpath)
    {
        return $xpath->addCondition("(name(.) = 'input' and @type = 'radio')");
    }
	public function translateCheckbox(XPathExpr $xpath)
    {
        return $xpath->addCondition("(name(.) = 'input' and @type = 'checkbox')");
    }
	public function translateSelected(XPathExpr $xpath)
    {
        return $xpath->addCondition("((@selected and name(.) = 'option') and parent::*[name(.) = 'select'])");
    }
	public function translateHeader(XPathExpr $xpath)
    {
        return $xpath->addCondition("(name(.) = 'h1' or name(.) = 'h2' or name(.)= 'h3' or name(.) = 'h4' or  name(.) = 'h5' or name(.) = 'h6')");
    }
	public function translateInput(XPathExpr $xpath)
    {
        return $xpath->addCondition(
		 '('
                .'('
                    ."(name(.) = 'input')"
                    ." or name(.) = 'button'"
                    ." or name(.) = 'select'"
                    ." or name(.) = 'textarea'"
                .')'
            .')'
		);
    }
	 public function translateButton(XPathExpr $xpath)
    {
        return $xpath->addCondition("(name(.) = 'button' or (name(.) = 'input' and @type = 'button'))");
    }
	 public function translateChecked(XPathExpr $xpath)
    {
        return $xpath->addCondition(
            '(@checked '
            ."and (name(.) = 'input' or name(.) = 'command')"
            ."and (@type = 'checkbox' or @type = 'radio'))"
        );
    }
	 public function translateDisabled(XPathExpr $xpath)
    {
        return $xpath->addCondition(
            '('
                .'@disabled and'
                .'('
                    ."(name(.) = 'input' and @type != 'hidden')"
                    ." or name(.) = 'button'"
                    ." or name(.) = 'select'"
                    ." or name(.) = 'textarea'"
                    ." or name(.) = 'command'"
                    ." or name(.) = 'fieldset'"
                    ." or name(.) = 'optgroup'"
                    ." or name(.) = 'option'"
                .')'
            .') or ('
                ."(name(.) = 'input' and @type != 'hidden')"
                ." or name(.) = 'button'"
                ." or name(.) = 'select'"
                ." or name(.) = 'textarea'"
            .')'
            .' and ancestor::fieldset[@disabled]'
        );
        // todo: in the second half, add "and is not a descendant of that fieldset element's first legend element child, if any."
    }
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'pseudo-class';
    }
}
