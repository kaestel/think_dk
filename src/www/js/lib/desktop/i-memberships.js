Util.Objects["memberships"] = new function() {
	this.init = function(scene) {
//		u.bug("scene init:" + u.nodeId(scene))

		scene.resized = function() {
//			u.bug("scene.resized:" + u.nodeId(this));

			if(this._membership_nodes) {

				var tallest_node = 0;
				var i, node;
				for(i = 0; node = this._membership_nodes[i]; i++) {
					u.ass(node, {
						"height":"auto"
					})
					u.bug(node.offsetHeight);
					tallest_node = tallest_node < node.offsetHeight ? node.offsetHeight : tallest_node;
				}
				for(i = 0; node = this._membership_nodes[i]; i++) {
					u.ass(node, {
						"height":(tallest_node+45)+"px"
					})
				}
			}

		}

		scene.scrolled = function() {
//			u.bug("scrolled:" + u.nodeId(this))
		}

		scene.ready = function() {
//			u.bug("scene.ready:" + u.nodeId(this));

			page.cN.scene = this;


			this._memberships = u.qs("div.memberships", this);
			var description = u.qs("div.articlebody", this);


			// move membership overview
			if(this._memberships && u.text(description).match(/\{div\.memberships\}/)) {
				for(i = 0; node = description.childNodes[i]; i++) {
					if(u.text(node).match(/\{div\.memberships\}/)) {
						description.replaceChild(this._memberships, node);
					}
				}
			}

			// make nodes available for resize calculation
			if(this._memberships) {
				this._membership_nodes = u.qsa(".membership", this._memberships);
			}


			u.showScene(this);


			page.resized();
		}


		// scene is ready
		scene.ready();

	}

}
