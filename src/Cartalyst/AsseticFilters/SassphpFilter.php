<?php namespace Cartalyst\AsseticFilters;
/**
 * Part of the Assetic Filters Package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.  It is also available at
 * the following URL: http://www.opensource.org/licenses/BSD-3-Clause
 *
 * @package    Assetic Filters
 * @version    2.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011 - 2013, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use Assetic\Asset\AssetInterface;
use Assetic\Filter\FilterInterface;

class SassphpFilter implements FilterInterface {

	/**
	 * Sassphp preset options.
	 *
	 * @var array
	 */
	protected $presets = array();

	/**
	 * Sassphp import paths.
	 *
	 * @var array
	 */
	protected $importPaths = array();

	/**
	 * Filters an asset after it has been loaded.
	 *
	 * @param Assetic\Asset\AssetInterface $asset
	 */
	public function filterLoad(AssetInterface $asset)
	{
		$root = $asset->getSourceRoot();
		$path = $asset->getSourcePath();

		$compiler = new \SassParser($this->presets);

		if ($root and $path)
		{
			$compiler->load_paths = array_merge($compiler->load_paths, array($root.'/'.$path));
		}

		$compiler->load_paths = array_merge($compiler->load_paths, $this->importPaths);

		$asset->setContent($compiler->toCss($asset->getContent(), false));
	}

	/**
	 * Filters an asset just before it's dumped.
	 *
	 * @param Assetic\Asset\AssetInterface $asset
	 */
	public function filterDump(AssetInterface $asset)
	{

	}

	public function setImportPaths(array $paths)
	{
		$this->importPaths = $paths;
	}

	public function addImportPath($path)
	{
		$this->importPaths[] = $path;
	}

}
