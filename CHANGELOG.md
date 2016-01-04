# Vimeo oEmbed Modifications Change Log

All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased]
### Fixed
- Correct fe_vom_oembed_fetch_url() returning an undefined variable when exiting early

## [1.2.0] - 2015-12-31
### Added
- composer.json file added

## [1.1.0] - 2015-12-31
### Added
- Flush Vimeo oEmbeds on Activation/Deactivation
### Changed
- Apply changes to oEmbed call instead of results. Change from `oembed_result`
hook to `oembed_fetch_url` hook

## [1.0.1] - 2015-12-31
### Changed
- Modify Example code to overwrite arguments rather than append. This is in
preparation for the day we introduce a default set of arguments

## [1.0.0] - 2015-12-30
### Added
Initial release
