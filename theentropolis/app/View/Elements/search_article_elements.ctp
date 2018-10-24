<form class="" method="post" action="<?php echo Router::url(array('controller' => 'EmergencyServices', 'action' => 'articleListing')) ?>">
				<div class="row">
					<div class="col-md-6 search-bx">
                                                <input type="text" class="form-control" name="searchTopic" id="searchTopic" placeholder="Search Help Topics" value="<?php echo (!isset($this->request->data['searchTopic'])) ? '' : $this->request->data['searchTopic'] ?>">
					</div>
					<div class="col-md-6 padding-none">
                                                <button type="submit" class="btn btn-orange btn-xs">SEARCH</button>
					</div>
				</div>
                            </form>